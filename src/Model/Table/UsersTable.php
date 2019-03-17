<?php

namespace Skeleton\Model\Table;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Http\Exception\ForbiddenException;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

/**
 * Users Model
 *
 * @property \Skeleton\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \Skeleton\Model\Table\FilesTable|\Cake\ORM\Association\BelongsTo $ProfileImageFile
 * @property \Skeleton\Model\Table\ContactsTable|\Cake\ORM\Association\HasMany $Contacts
 * @property \Skeleton\Model\Table\DevicesTable|\Cake\ORM\Association\HasMany $Devices
 * @property \Skeleton\Model\Table\FilesTable|\Cake\ORM\Association\HasMany $Files
 * @property \Skeleton\Model\Table\LoginsTable|\Cake\ORM\Association\HasMany $Logins
 * @property \Skeleton\Model\Table\LogsTable|\Cake\ORM\Association\HasMany $Logs
 * @property \Skeleton\Model\Table\OauthAccessTokensTable|\Cake\ORM\Association\HasMany $OauthAccessTokens
 * @property \Skeleton\Model\Table\OauthAuthorizationCodesTable|\Cake\ORM\Association\HasMany $OauthAuthorizationCodes
 * @property \Skeleton\Model\Table\OauthClientsTable|\Cake\ORM\Association\HasMany $OauthClients
 * @property \Skeleton\Model\Table\SearchHistoriesTable|\Cake\ORM\Association\HasMany $SearchHistories
 *
 * @method \Skeleton\Model\Entity\User get($primaryKey, $options = [])
 * @method \Skeleton\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \Skeleton\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \Skeleton\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table implements UserRepositoryInterface
{
    use SoftDeleteTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ProfileImageFile', [
            'className' => 'Files',
            'foreignKey' => 'profile_image_id'
        ]);
        $this->hasMany('Contacts', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Devices', [
            'foreignKey' => 'user_id',
            'cascadeCallbacks' => true,
            'dependent' => true
        ]);
        $this->hasMany('Files', [
            'foreignKey' => 'user_id',
            'cascadeCallbacks' => true,
            'dependent' => true
        ]);
        $this->hasMany('Logins', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Logs', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('OauthAccessTokens', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('OauthAuthorizationCodes', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('OauthClients', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('SearchHistories', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 30)
            ->allowEmptyString('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 60)
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', false);

        $validator
            ->scalar('given_name')
            ->maxLength('given_name', 45)
            ->requirePresence('given_name', 'create')
            ->allowEmptyString('given_name', false);

        $validator
            ->scalar('family_name')
            ->maxLength('family_name', 45)
            ->requirePresence('family_name', 'create')
            ->allowEmptyString('family_name', false);

        $validator
            ->date('birthdate')
            ->requirePresence('birthdate', 'create')
            ->allowEmptyDate('birthdate', false);

        $validator
            ->scalar('gender')
            ->requirePresence('gender', 'create')
            ->allowEmptyString('gender', false);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['profile_image_id'], 'ProfileImageFile'));

        return $rules;
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findMinimumInfo(Query $query, array $options)
    {
        return $query->select(['id', 'profile_image_url' => 'ProfileImageFile.url'])
            ->contain('ProfileImageFile');
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findBasicInfo(Query $query, array $options)
    {
        return $query->find('minimumInfo')
            ->select([
                'given_name',
                'birthdate',
                'gender',
            ]);
    }

    public function findByUsername(Query $query, array $options)
    {
        $username = $options['username'] ?? null;

        return $query
            ->leftJoin('contacts', 'users.id = contacts.user_id')
            ->where([
                'OR' => [
                    'username' => $username,
                    'contacts.contact' => $username
                ]
            ]);
    }

    /**
     * Get a user entity.
     *
     * @param string $username
     * @param string $password
     * @param string $grantType The grant type used
     * @param ClientEntityInterface $clientEntity
     *
     * @return UserEntityInterface
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        $user = $this->find('byUsername', ['username' => $username])
            ->contain(['Clients'])
            ->where([
                'password' => (new DefaultPasswordHasher())->hash($password),
                'failed_login_attempts < 5'
            ])->first();

        // reset failed login attempts to 0
        if ($user && $user->get('failed_login_attempts')) {
            $this->find()->update()->set('failed_login_attempts', 0)->execute();
            $user->set('failed_login_attempts', 0);
        }

        return $user;
    }

    /**
     * Record the failed login attempt, 5 attempts allowed.
     * @param string $username
     */
    public function recordFailedLoginAttempt($username)
    {
        $failed_login_attempts = $this->find()
            ->select('failed_login_attempts')
            ->find('byUsername', ['username' => $username])
            ->first()->get('failed_login_attempts');

        if ($failed_login_attempts >= 5) {
            throw new ForbiddenException('Your account has been locked due to too many failed login attempts');
        }

        $this->find()->update()->set('failed_login_attempts', $failed_login_attempts + 1)->execute();
    }
}
