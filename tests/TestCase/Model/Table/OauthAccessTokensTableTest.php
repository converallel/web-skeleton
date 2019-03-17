<?php
namespace Skeleton\Test\TestCase\Model\Table;

use Skeleton\Model\Table\OauthAccessTokensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Model\Table\OauthAccessTokensTable Test Case
 */
class OauthAccessTokensTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Skeleton\Model\Table\OauthAccessTokensTable
     */
    public $OauthAccessTokens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OauthAccessTokens',
        'app.Users',
        'app.OauthClients',
        'app.OauthRefreshTokens',
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
        $config = TableRegistry::getTableLocator()->exists('OauthAccessTokens') ? [] : ['className' => OauthAccessTokensTable::class];
        $this->OauthAccessTokens = TableRegistry::getTableLocator()->get('OauthAccessTokens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OauthAccessTokens);

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
