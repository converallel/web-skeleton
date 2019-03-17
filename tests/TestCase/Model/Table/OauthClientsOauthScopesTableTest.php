<?php
namespace Skeleton\Test\TestCase\Model\Table;

use Skeleton\Model\Table\OauthClientsOauthScopesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Model\Table\OauthClientsOauthScopesTable Test Case
 */
class OauthClientsOauthScopesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Skeleton\Model\Table\OauthClientsOauthScopesTable
     */
    public $OauthClientsOauthScopes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OauthClientsOauthScopes',
        'app.OauthClients',
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
        $config = TableRegistry::getTableLocator()->exists('OauthClientsOauthScopes') ? [] : ['className' => OauthClientsOauthScopesTable::class];
        $this->OauthClientsOauthScopes = TableRegistry::getTableLocator()->get('OauthClientsOauthScopes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OauthClientsOauthScopes);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
