<?php
namespace Skeleton\Test\TestCase\Controller;

use Skeleton\Controller\LocationsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Controller\LocationsController Test Case
 */
class LocationsControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
     * Test lookup method
     *
     * @return void
     */
    public function testLookup()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
