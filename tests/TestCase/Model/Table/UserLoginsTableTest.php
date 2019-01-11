<?php
namespace Skeleton\Test\TestCase\Model\Table;

use Skeleton\Model\Table\UserLoginsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Model\Table\UserLoginsTable Test Case
 */
class UserLoginsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Skeleton\Model\Table\UserLoginsTable
     */
    public $UserLogins;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UserLogins',
        'app.Users',
        'app.Devices'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UserLogins') ? [] : ['className' => UserLoginsTable::class];
        $this->UserLogins = TableRegistry::getTableLocator()->get('UserLogins', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserLogins);

        parent::tearDown();
    }

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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
