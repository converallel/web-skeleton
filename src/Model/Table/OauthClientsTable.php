<?php

namespace Skeleton\Model\Table;

use Cake\Http\Exception\UnauthorizedException;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

/**
 * OauthClients Model
 *
 * @property \Skeleton\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \Skeleton\Model\Table\OauthAccessTokensTable|\Cake\ORM\Association\HasMany $OauthAccessTokens
 * @property \Skeleton\Model\Table\OauthAuthorizationCodesTable|\Cake\ORM\Association\HasMany $OauthAuthorizationCodes
 * @property \Skeleton\Model\Table\OauthScopesTable|\Cake\ORM\Association\BelongsToMany $OauthScopes
 *
 * @method \Skeleton\Model\Entity\OauthClient get($primaryKey, $options = [])
 * @method \Skeleton\Model\Entity\OauthClient newEntity($data = null, array $options = [])
 * @method \Skeleton\Model\Entity\OauthClient[] newEntities(array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthClient|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthClient|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthClient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthClient[] patchEntities($entities, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthClient findOrCreate($search, callable $callback = null, $options = [])
 */
class OauthClientsTable extends Table implements ClientRepositoryInterface
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

        $this->setTable('oauth_clients');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('OauthAccessTokens', [
            'foreignKey' => 'oauth_client_id'
        ]);
        $this->hasMany('OauthAuthorizationCodes', [
            'foreignKey' => 'oauth_client_id'
        ]);
        $this->belongsToMany('OauthScopes', [
            'foreignKey' => 'oauth_client_id',
            'targetForeignKey' => 'oauth_scope_id',
            'joinTable' => 'oauth_clients_oauth_scopes'
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('secret')
            ->maxLength('secret', 80)
            ->requirePresence('secret', 'create')
            ->allowEmptyString('secret', false);

        $validator
            ->scalar('redirect_uri')
            ->requirePresence('redirect_uri', 'create')
            ->allowEmptyString('redirect_uri', false);

        $validator
            ->scalar('grant_type')
            ->requirePresence('grant_type', 'create')
            ->allowEmptyString('grant_type', false);

        $validator
            ->boolean('revoked')
            ->allowEmptyString('revoked', false);

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

        return $rules;
    }

    /**
     * Get a client.
     *
     * @param string $clientIdentifier The client's identifier
     * @param null|string $grantType The grant type used (if sent)
     * @param null|string $clientSecret The client's secret (if sent)
     * @param bool $mustValidateSecret If true the client must attempt to validate the secret if the client
     *                                        is confidential
     *
     * @return ClientEntityInterface
     */
    public function getClientEntity(
        $clientIdentifier,
        $grantType = null,
        $clientSecret = null,
        $mustValidateSecret = true
    ) {
        $client = $this->get($clientIdentifier);
        if ($mustValidateSecret) {
            if ($client->secret !== $clientSecret) {
                throw new UnauthorizedException('Invalid client secret');
            }
        }
        $grantTypes = explode(',', $client->grant_type);
        if (!in_array($grantType, $grantTypes)) {
            throw new UnauthorizedException('Invalid grant type');
        }

        return $client;
    }
}
