<?php

namespace Skeleton\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Skeleton\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \Skeleton\Model\Table\FilesTable|\Cake\ORM\Association\BelongsTo $ProfileImageFile
 * @property \Skeleton\Model\Table\ContactsTable|\Cake\ORM\Association\HasMany $Contacts
 * @property \Skeleton\Model\Table\DevicesTable|\Cake\ORM\Association\HasMany $Devices
 * @property \Skeleton\Model\Table\FilesTable|\Cake\ORM\Association\HasMany $Files
 * @property \Skeleton\Model\Table\LogsTable|\Cake\ORM\Association\HasMany $Logs
 * @property \Skeleton\Model\Table\SearchHistoriesTable|\Cake\ORM\Association\HasMany $SearchHistories
 * @property \Skeleton\Model\Table\UserLoginsTable|\Cake\ORM\Association\HasMany $UserLogins
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
class UsersTable extends Table
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
        $this->hasMany('Logs', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('SearchHistories', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UserLogins', [
            'foreignKey' => 'user_id'
        ]);
    }

    public function beforeMarshal(Event $event, \ArrayObject $data, \ArrayObject $options)
    {
        if (isset($data['password'])) {
            $data['password'] = (string)$data['password'];
        }
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
            ->email('email')
            ->allowEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('phone_number')
            ->lengthBetween('phone_number', [6, 20])
            ->requirePresence('phone_number', function ($context) {
                return $context['newRecord'] && !isset($context['data']['email']);
            }, "Email and phone number can't both be empty")
            ->add('phone_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->minLength('password', 6)
            ->requirePresence('password', 'create');

        $validator
            ->requirePresence('failed_login_attempts', 'create')
            ->allowEmptyString('failed_login_attempts', false);

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['phone_number']));
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
}
