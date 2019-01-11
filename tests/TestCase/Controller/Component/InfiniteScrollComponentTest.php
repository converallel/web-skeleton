<?php
namespace Skeleton\Test\TestCase\Controller\Component;

use Skeleton\Controller\Component\InfiniteScrollComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Controller\Component\InfiniteScrollComponent Test Case
 */
class InfiniteScrollComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Skeleton\Controller\Component\InfiniteScrollComponent
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
