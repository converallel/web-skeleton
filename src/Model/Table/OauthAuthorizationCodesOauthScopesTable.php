<?php

namespace Skeleton\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * OauthAuthorizationCodesOauthScopes Model
 *
 * @property \Skeleton\Model\Table\OauthAuthorizationCodesTable|\Cake\ORM\Association\BelongsTo $OauthAuthorizationCodes
 * @property \Skeleton\Model\Table\OauthScopesTable|\Cake\ORM\Association\BelongsTo $OauthScopes
 *
 * @method \Skeleton\Model\Entity\OauthAuthorizationCodesOauthScope get($primaryKey, $options = [])
 * @method \Skeleton\Model\Entity\OauthAuthorizationCodesOauthScope newEntity($data = null, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAuthorizationCodesOauthScope[] newEntities(array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAuthorizationCodesOauthScope|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthAuthorizationCodesOauthScope|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthAuthorizationCodesOauthScope patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAuthorizationCodesOauthScope[] patchEntities($entities, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthAuthorizationCodesOauthScope findOrCreate($search, callable $callback = null, $options = [])
 */
class OauthAuthorizationCodesOauthScopesTable extends Table
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

        $this->setTable('oauth_authorization_codes_oauth_scopes');
        $this->setDisplayField('oauth_authorization_code_id');
        $this->setPrimaryKey(['oauth_authorization_code_id', 'oauth_scope_id']);

        $this->belongsTo('OauthAuthorizationCodes', [
            'foreignKey' => 'oauth_authorization_code_id',
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
        $rules->add($rules->existsIn(['oauth_authorization_code_id'], 'OauthAuthorizationCodes'));
        $rules->add($rules->existsIn(['oauth_scope_id'], 'OauthScopes'));

        return $rules;
    }
}
