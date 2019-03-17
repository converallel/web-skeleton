<?php

namespace Skeleton\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

/**
 * OauthScopes Model
 *
 * @property \Skeleton\Model\Table\OauthAccessTokensTable|\Cake\ORM\Association\BelongsToMany $OauthAccessTokens
 * @property \Skeleton\Model\Table\OauthAuthorizationCodesTable|\Cake\ORM\Association\BelongsToMany $OauthAuthorizationCodes
 * @property \Skeleton\Model\Table\OauthClientsTable|\Cake\ORM\Association\BelongsToMany $OauthClients
 *
 * @method \Skeleton\Model\Entity\OauthScope get($primaryKey, $options = [])
 * @method \Skeleton\Model\Entity\OauthScope newEntity($data = null, array $options = [])
 * @method \Skeleton\Model\Entity\OauthScope[] newEntities(array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthScope|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthScope|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\OauthScope patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthScope[] patchEntities($entities, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\OauthScope findOrCreate($search, callable $callback = null, $options = [])
 */
class OauthScopesTable extends Table implements ScopeRepositoryInterface
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

        $this->setTable('oauth_scopes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsToMany('OauthAccessTokens', [
            'foreignKey' => 'oauth_scope_id',
            'targetForeignKey' => 'oauth_access_token_id',
            'joinTable' => 'oauth_access_tokens_oauth_scopes'
        ]);
        $this->belongsToMany('OauthAuthorizationCodes', [
            'foreignKey' => 'oauth_scope_id',
            'targetForeignKey' => 'oauth_authorization_code_id',
            'joinTable' => 'oauth_authorization_codes_oauth_scopes'
        ]);
        $this->belongsToMany('OauthClients', [
            'foreignKey' => 'oauth_scope_id',
            'targetForeignKey' => 'oauth_client_id',
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
            ->scalar('id')
            ->maxLength('id', 40)
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('description')
            ->maxLength('description', 100)
            ->requirePresence('description', 'create')
            ->allowEmptyString('description', false);

        return $validator;
    }

    /**
     * Return information about a scope.
     *
     * @param string $identifier The scope identifier
     *
     * @return ScopeEntityInterface
     */
    public function getScopeEntityByIdentifier($identifier)
    {
        return $this->get($identifier);
    }

    /**
     * Given a client, grant type and optional user identifier validate the set of scopes requested are valid and optionally
     * append additional scopes or remove requested scopes.
     *
     * @param ScopeEntityInterface[] $scopes
     * @param string $grantType
     * @param ClientEntityInterface $clientEntity
     * @param null|string $userIdentifier
     *
     * @return ScopeEntityInterface[]
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ) {
//        $clientId = $clientEntity->getIdentifier();
//
//        $client = TableRegistry::getTableLocator()->get('Clients')->get($clientId, ['contain' => ['Scopes']]);
//        $clientScopes = array_map(function ($scope) {
//            return $scope->getIdentifier();
//        }, $client->get('scopes'));
//
//        $requestedScopes = array_map(function ($scope) {
//            return $scope->getIdentifier();
//        }, $scopes);
//
//        if ($invalidScopes = array_diff($requestedScopes, $clientScopes)) {
//            throw new BadRequestException("Invalid scope: " . implode(', ', $invalidScopes));
//        }
        if (empty($scopes)) {
            $scopes[] = $this->getScopeEntityByIdentifier('Default');
        }

        return $scopes;
    }
}
