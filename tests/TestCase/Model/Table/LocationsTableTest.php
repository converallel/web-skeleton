<?php
namespace Skeleton\Test\TestCase\Model\Table;

use Skeleton\Model\Table\LocationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Model\Table\LocationsTable Test Case
 */
class LocationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Skeleton\Model\Table\LocationsTable
     */
    public $Locations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Locations',
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
        $config = TableRegistry::getTableLocator()->exists('Locations') ? [] : ['className' => LocationsTable::class];
        $this->Locations = TableRegistry::getTableLocator()->get('Locations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Locations);

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
}
