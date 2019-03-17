<?php
namespace Skeleton\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Controller\UsersController Test Case
 */
class usersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Users',
        'app.Locations',
        'app.ProfileImageFile',
        'app.Contacts',
        'app.Devices',
        'app.Files',
        'app.Logins',
        'app.Logs',
        'app.OauthAccessTokens',
        'app.OauthAuthorizationCodes',
        'app.OauthClients',
        'app.SearchHistories'
    ];

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
