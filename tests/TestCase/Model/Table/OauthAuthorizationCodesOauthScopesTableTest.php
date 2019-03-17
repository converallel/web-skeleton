<?php
namespace Skeleton\Test\TestCase\Model\Table;

use Skeleton\Model\Table\OauthAuthorizationCodesOauthScopesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Model\Table\OauthAuthorizationCodesOauthScopesTable Test Case
 */
class OauthAuthorizationCodesOauthScopesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Skeleton\Model\Table\OauthAuthorizationCodesOauthScopesTable
     */
    public $OauthAuthorizationCodesOauthScopes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OauthAuthorizationCodesOauthScopes',
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
        $config = TableRegistry::getTableLocator()->exists('OauthAuthorizationCodesOauthScopes') ? [] : ['className' => OauthAuthorizationCodesOauthScopesTable::class];
        $this->OauthAuthorizationCodesOauthScopes = TableRegistry::getTableLocator()->get('OauthAuthorizationCodesOauthScopes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OauthAuthorizationCodesOauthScopes);

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
