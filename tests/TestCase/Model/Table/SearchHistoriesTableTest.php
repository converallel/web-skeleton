<?php
namespace Skeleton\Test\TestCase\Model\Table;

use Skeleton\Model\Table\SearchHistoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Model\Table\SearchHistoriesTable Test Case
 */
class SearchHistoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Skeleton\Model\Table\SearchHistoriesTable
     */
    public $SearchHistories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SearchHistories',
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
        $config = TableRegistry::getTableLocator()->exists('SearchHistories') ? [] : ['className' => SearchHistoriesTable::class];
        $this->SearchHistories = TableRegistry::getTableLocator()->get('SearchHistories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SearchHistories);

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
