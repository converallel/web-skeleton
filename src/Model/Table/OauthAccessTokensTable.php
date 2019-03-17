<?php

namespace Skeleton\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

/**
 * OauthAccessTokens Model
 *
 * @property \Skeleton\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \Skeleton\Model\Table\OauthClientsTable|\Cake\ORM\Association\BelongsTo $OauthClients
 * @property \Skeleton\Model\Table\OauthRefreshTokensTable|\Cake\ORM\Association\HasMany $OauthRefreshTokens
 * @property \Skeleton\Model\Table\OauthScopesTable|\Cake\ORM\Association\BelongsToMany $OauthScopes
 *
 * @method \Skeleton\Model\Entity\OauthAccessToken get($primaryKey, $options = [])
 * @method \Skeleton\Model\Entity\OauthAccessToken newEntity($data = null, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAccessToken[] newEntities(array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAccessToken|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthAccessToken|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthAccessToken patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAccessToken[] patchEntities($entities, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAccessToken findOrCreate($search, callable $callback = null, $options = [])
 */
class OauthAccessTokensTable extends Table implements AccessTokenRepositoryInterface
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

        $this->setTable('oauth_access_tokens');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OauthClients', [
            'foreignKey' => 'oauth_client_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('OauthRefreshTokens', [
            'foreignKey' => 'oauth_access_token_id'
        ]);
        $this->belongsToMany('OauthScopes', [
            'foreignKey' => 'oauth_access_token_id',
            'targetForeignKey' => 'oauth_scope_id',
            'joinTable' => 'oauth_access_tokens_oauth_scopes'
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
            ->maxLength('id', 80)
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

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
     * Create a new access token
     *
     * @param ClientEntityInterface $clientEntity
     * @param ScopeEntityInterface[] $scopes
     * @param mixed $userIdentifier
     *
     * @return AccessTokenEntityInterface
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = $this->newEntity([
            'user_id' => $userIdentifier,
            'client_id' => $clientEntity->getIdentifier(),
            'scopes' => $scopes,
        ]);

        return $accessToken;
    }

    /**
     * Persists a new access token to permanent storage.
     *
     * @param AccessTokenEntityInterface $accessTokenEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $accessTokenId = $accessTokenEntity->getIdentifier();
        if ($this->exists(['id' => $accessTokenId])) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }
        if ($this->save($accessTokenEntity)) {
        } else {
            var_dump($accessTokenEntity->getErrors());
            exit;
        }
    }

    /**
     * Revoke an access token.
     *
     * @param string $tokenId
     */
    public function revokeAccessToken($tokenId)
    {
        $accessToken = $this->get($tokenId);
        $accessToken->revoked = true;
        $this->save($accessToken);
    }

    /**
     * Check if the access token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isAccessTokenRevoked($tokenId)
    {
        return $this->get($tokenId, ['fields' => 'revoked'])->revoked;
    }
}
