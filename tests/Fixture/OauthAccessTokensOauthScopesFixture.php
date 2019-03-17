<?php
namespace Skeleton\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OauthAccessTokensOauthScopesFixture
 *
 */
class OauthAccessTokensOauthScopesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'oauth_access_token_id' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'oauth_scope_id' => ['type' => 'string', 'length' => 40, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'oauth_scope_id' => ['type' => 'index', 'columns' => ['oauth_scope_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['oauth_access_token_id', 'oauth_scope_id'], 'length' => []],
            'oauth_access_tokens_oauth_scopes_ibfk_1' => ['type' => 'foreign', 'columns' => ['oauth_access_token_id'], 'references' => ['oauth_access_tokens', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'oauth_access_tokens_oauth_scopes_ibfk_2' => ['type' => 'foreign', 'columns' => ['oauth_scope_id'], 'references' => ['oauth_scopes', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'oauth_access_token_id' => '1e00744b-82bb-425f-bb60-3117d394ab1c',
                'oauth_scope_id' => '09858ab8-2962-4a90-b2a6-2f00414c0d24'
            ],
        ];
        parent::init();
    }
}
