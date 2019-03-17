<?php

namespace Skeleton\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

/**
 * OauthAuthorizationCodes Model
 *
 * @property \Skeleton\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \Skeleton\Model\Table\OauthClientsTable|\Cake\ORM\Association\BelongsTo $OauthClients
 * @property \Skeleton\Model\Table\OauthScopesTable|\Cake\ORM\Association\BelongsToMany $OauthScopes
 *
 * @method \Skeleton\Model\Entity\OauthAuthorizationCode get($primaryKey, $options = [])
 * @method \Skeleton\Model\Entity\OauthAuthorizationCode newEntity($data = null, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAuthorizationCode[] newEntities(array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAuthorizationCode|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthAuthorizationCode|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthAuthorizationCode patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAuthorizationCode[] patchEntities($entities, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAuthorizationCode findOrCreate($search, callable $callback = null, $options = [])
 */
class OauthAuthorizationCodesTable extends Table implements AuthCodeRepositoryInterface
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('oauth_authorization_codes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OauthClients', [
            'foreignKey' => 'oauth_client_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('OauthScopes', [
            'foreignKey' => 'oauth_authorization_code_id',
            'targetForeignKey' => 'oauth_scope_id',
            'joinTable' => 'oauth_authorization_codes_oauth_scopes'
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
            ->scalar('id')
            ->maxLength('id', 100)
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('redirect_uri')
            ->allowEmptyString('redirect_uri');

        $validator
            ->scalar('id_token')
            ->allowEmptyString('id_token');

        $validator
            ->boolean('revoked')
            ->allowEmptyString('revoked', false);

        $validator
            ->dateTime('expires_at')
            ->allowEmptyDateTime('expires_at');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['oauth_client_id'], 'OauthClients'));

        return $rules;
    }

    /**
     * Creates a new AuthCode
     *
     * @return AuthCodeEntityInterface
     */
    public function getNewAuthCode()
    {
        return $this->newEntity();
    }

    /**
     * Persists a new auth code to permanent storage.
     *
     * @param AuthCodeEntityInterface $authCodeEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        $this->save($authCodeEntity);
    }

    /**
     * Revoke an auth code.
     *
     * @param string $codeId
     */
    public function revokeAuthCode($codeId)
    {
        $this->find()->update()->set('revoked', true)->where(['id' => $codeId])->execute();
    }

    /**
     * Check if the auth code has been revoked.
     *
     * @param string $codeId
     *
     * @return bool Return true if this code has been revoked
     */
    public function isAuthCodeRevoked($codeId)
    {
        return $this->get($codeId, ['fields' => 'revoked'])->revoked;
    }
}
