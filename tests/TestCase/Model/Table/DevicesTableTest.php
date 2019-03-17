<?php
namespace Skeleton\Test\TestCase\Model\Table;

use Skeleton\Model\Table\DevicesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Model\Table\DevicesTable Test Case
 */
class DevicesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Skeleton\Model\Table\DevicesTable
     */
    public $Devices;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Devices',
        'app.Users',
        'app.Logins'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Devices') ? [] : ['className' => DevicesTable::class];
        $this->Devices = TableRegistry::getTableLocator()->get('Devices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Devices);

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
