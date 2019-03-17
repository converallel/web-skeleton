<?php

namespace Skeleton\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * OauthAccessTokensOauthScopes Model
 *
 * @property \Skeleton\Model\Table\OauthAccessTokensTable|\Cake\ORM\Association\BelongsTo $OauthAccessTokens
 * @property \Skeleton\Model\Table\OauthScopesTable|\Cake\ORM\Association\BelongsTo $OauthScopes
 *
 * @method \Skeleton\Model\Entity\OauthAccessTokensOauthScope get($primaryKey, $options = [])
 * @method \Skeleton\Model\Entity\OauthAccessTokensOauthScope newEntity($data = null, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAccessTokensOauthScope[] newEntities(array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAccessTokensOauthScope|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthAccessTokensOauthScope|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthAccessTokensOauthScope patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAccessTokensOauthScope[] patchEntities($entities, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAccessTokensOauthScope findOrCreate($search, callable $callback = null, $options = [])
 */
class OauthAccessTokensOauthScopesTable extends Table
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

        $this->setTable('oauth_access_tokens_oauth_scopes');
        $this->setDisplayField('oauth_access_token_id');
        $this->setPrimaryKey(['oauth_access_token_id', 'oauth_scope_id']);

        $this->belongsTo('OauthAccessTokens', [
            'foreignKey' => 'oauth_access_token_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OauthScopes', [
            'foreignKey' => 'oauth_scope_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['oauth_scope_id'], 'OauthScopes'));

        return $rules;
    }
}
