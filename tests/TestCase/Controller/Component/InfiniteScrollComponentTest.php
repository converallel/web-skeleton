<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\InfiniteScrollComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\InfiniteScrollComponent Test Case
 */
class InfiniteScrollComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\InfiniteScrollComponent
     */
    public $InfiniteScroll;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->InfiniteScroll = new InfiniteScrollComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InfiniteScroll);

        parent::tearDown();
    }

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
