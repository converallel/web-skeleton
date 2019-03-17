<?php
namespace Skeleton\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OauthAuthorizationCodesOauthScopesFixture
 *
 */
class OauthAuthorizationCodesOauthScopesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'oauth_authorization_code_id' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'oauth_scope_id' => ['type' => 'string', 'length' => 40, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'oauth_scope_id' => ['type' => 'index', 'columns' => ['oauth_scope_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['oauth_authorization_code_id', 'oauth_scope_id'], 'length' => []],
            'oauth_authorization_codes_oauth_scopes_ibfk_1' => ['type' => 'foreign', 'columns' => ['oauth_authorization_code_id'], 'references' => ['oauth_authorization_codes', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'oauth_authorization_codes_oauth_scopes_ibfk_2' => ['type' => 'foreign', 'columns' => ['oauth_scope_id'], 'references' => ['oauth_scopes', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'oauth_authorization_code_id' => 'ce7e7d25-939f-49a5-9c39-162a24960cfe',
                'oauth_scope_id' => 'd492e692-a02c-4809-910f-e060f267f45b'
            ],
        ];
        parent::init();
    }
}
