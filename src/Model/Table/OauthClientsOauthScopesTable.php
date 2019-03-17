<?php

namespace Skeleton\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * OauthClientsOauthScopes Model
 *
 * @property \Skeleton\Model\Table\OauthClientsTable|\Cake\ORM\Association\BelongsTo $OauthClients
 * @property \Skeleton\Model\Table\OauthScopesTable|\Cake\ORM\Association\BelongsTo $OauthScopes
 *
 * @method \Skeleton\Model\Entity\OauthClientsOauthScope get($primaryKey, $options = [])
 * @method \Skeleton\Model\Entity\OauthClientsOauthScope newEntity($data = null, array $options = [])
 * @method \Skeleton\Model\Entity\OauthClientsOauthScope[] newEntities(array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthClientsOauthScope|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthClientsOauthScope|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthClientsOauthScope patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthClientsOauthScope[] patchEntities($entities, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthClientsOauthScope findOrCreate($search, callable $callback = null, $options = [])
 */
class OauthClientsOauthScopesTable extends Table
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

        $this->setTable('oauth_clients_oauth_scopes');
        $this->setDisplayField('oauth_client_id');
        $this->setPrimaryKey(['oauth_client_id', 'oauth_scope_id']);

        $this->belongsTo('OauthClients', [
            'foreignKey' => 'oauth_client_id',
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
        $rules->add($rules->existsIn(['oauth_client_id'], 'OauthClients'));
        $rules->add($rules->existsIn(['oauth_scope_id'], 'OauthScopes'));

        return $rules;
    }
}
