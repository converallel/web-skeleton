<?php
namespace Skeleton\Test\TestCase\Model\Table;

use Skeleton\Model\Table\OauthClientsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Model\Table\OauthClientsTable Test Case
 */
class OauthClientsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Skeleton\Model\Table\OauthClientsTable
     */
    public $OauthClients;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OauthClients',
        'app.Users',
        'app.OauthAccessTokens',
        'app.OauthAuthorizationCodes',
        'app.OauthScopes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OauthClients') ? [] : ['className' => OauthClientsTable::class];
        $this->OauthClients = TableRegistry::getTableLocator()->get('OauthClients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OauthClients);

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
