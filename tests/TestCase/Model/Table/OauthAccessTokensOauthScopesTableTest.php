<?php
namespace Skeleton\Test\TestCase\Model\Table;

use Skeleton\Model\Table\OauthAccessTokensOauthScopesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Model\Table\OauthAccessTokensOauthScopesTable Test Case
 */
class OauthAccessTokensOauthScopesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Skeleton\Model\Table\OauthAccessTokensOauthScopesTable
     */
    public $OauthAccessTokensOauthScopes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OauthAccessTokensOauthScopes',
        'app.OauthAccessTokens',
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
        $config = TableRegistry::getTableLocator()->exists('OauthAccessTokensOauthScopes') ? [] : ['className' => OauthAccessTokensOauthScopesTable::class];
        $this->OauthAccessTokensOauthScopes = TableRegistry::getTableLocator()->get('OauthAccessTokensOauthScopes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OauthAccessTokensOauthScopes);

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
