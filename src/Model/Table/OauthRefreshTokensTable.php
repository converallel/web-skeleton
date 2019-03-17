<?php

namespace Skeleton\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

/**
 * OauthRefreshTokens Model
 *
 * @property \Skeleton\Model\Table\OauthAccessTokensTable|\Cake\ORM\Association\BelongsTo $OauthAccessTokens
 *
 * @method \Skeleton\Model\Entity\OauthRefreshToken get($primaryKey, $options = [])
 * @method \Skeleton\Model\Entity\OauthRefreshToken newEntity($data = null, array $options = [])
 * @method \Skeleton\Model\Entity\OauthRefreshToken[] newEntities(array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthRefreshToken|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthRefreshToken|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthRefreshToken patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthRefreshToken[] patchEntities($entities, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthRefreshToken findOrCreate($search, callable $callback = null, $options = [])
 */
class OauthRefreshTokensTable extends Table implements RefreshTokenRepositoryInterface
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

        $this->setTable('oauth_refresh_tokens');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('OauthAccessTokens', [
            'foreignKey' => 'oauth_access_token_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['oauth_access_token_id'], 'OauthAccessTokens'));

        return $rules;
    }

    /**
     * Creates a new refresh token
     *
     * @return RefreshTokenEntityInterface
     */
    public function getNewRefreshToken()
    {
        return $this->newEntity();
    }

    /**
     * Create a new refresh token_name.
     *
     * @param RefreshTokenEntityInterface $refreshTokenEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        $this->save($refreshTokenEntity);
    }

    /**
     * Revoke the refresh token.
     *
     * @param string $tokenId
     */
    public function revokeRefreshToken($tokenId)
    {
        $this->find()->update()->set('revoked', true)->where(['id' => $tokenId])->execute();
    }

    /**
     * Check if the refresh token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        return $this->get($tokenId, ['fields' => 'revoked'])->revoked;
    }
}
