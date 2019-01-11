<?php
namespace Skeleton\Test\TestCase\Controller;

use Skeleton\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Controller\UsersController Test Case
 */
class UsersControllerTest extends TestCase
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
        'app.Personalities',
        'app.Education',
        'app.AdministratedActivities',
        'app.ActivityFilterEducation',
        'app.ActivityFilters',
        'app.Applications',
        'app.Contacts',
        'app.Devices',
        'app.Files',
        'app.LocationSelectionHistories',
        'app.Logs',
        'app.Reviews',
        'app.SearchHistories',
        'app.UserLogins',
        'app.Activities',
        'app.Tags'
    ];

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test login method
     *
     * @return void
     */
    public function testLogin()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
