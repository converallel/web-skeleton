<?php
namespace Skeleton\Test\TestCase\Model\Table;

use Skeleton\Model\Table\LogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Model\Table\LogsTable Test Case
 */
class LogsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Skeleton\Model\Table\LogsTable
     */
    public $Logs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Logs',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Logs') ? [] : ['className' => LogsTable::class];
        $this->Logs = TableRegistry::getTableLocator()->get('Logs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Logs);

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
