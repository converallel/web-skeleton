<?php
namespace Skeleton\Test\TestCase\Model\Behavior;

use Skeleton\Model\Behavior\SearchableBehavior;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Model\Behavior\SearchableBehavior Test Case
 */
class SearchableBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Skeleton\Model\Behavior\SearchableBehavior
     */
    public $Searchable;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Searchable = new SearchableBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Searchable);

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
