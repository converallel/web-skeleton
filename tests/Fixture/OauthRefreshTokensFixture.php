<?php
namespace Skeleton\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OauthRefreshTokensFixture
 *
 */
class OauthRefreshTokensFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'string', 'fixed' => true, 'length' => 80, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'oauth_access_token_id' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'revoked' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'expires_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'oauth_access_token_id' => ['type' => 'index', 'columns' => ['oauth_access_token_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'oauth_refresh_tokens_ibfk_1' => ['type' => 'foreign', 'columns' => ['oauth_access_token_id'], 'references' => ['oauth_access_tokens', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'id' => '56e47efa-cae7-4e85-baaa-5d6731cf15fa',
                'oauth_access_token_id' => 'Lorem ipsum dolor sit amet',
                'revoked' => 1,
                'expires_at' => 1552758388
            ],
        ];
        parent::init();
    }
}
