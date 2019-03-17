<?php
namespace Skeleton\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OauthClientsOauthScopesFixture
 *
 */
class OauthClientsOauthScopesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'oauth_client_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'oauth_scope_id' => ['type' => 'string', 'length' => 40, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'oauth_scope_id' => ['type' => 'index', 'columns' => ['oauth_scope_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['oauth_client_id', 'oauth_scope_id'], 'length' => []],
            'oauth_clients_oauth_scopes_ibfk_1' => ['type' => 'foreign', 'columns' => ['oauth_client_id'], 'references' => ['oauth_clients', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'oauth_clients_oauth_scopes_ibfk_2' => ['type' => 'foreign', 'columns' => ['oauth_scope_id'], 'references' => ['oauth_scopes', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'oauth_client_id' => 1,
                'oauth_scope_id' => 'c6177d79-39b4-42d9-9d3f-a4d3705e01d1'
            ],
        ];
        parent::init();
    }
}
