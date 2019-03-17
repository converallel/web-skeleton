<?php
namespace Skeleton\Test\TestCase\Model\Table;

use Skeleton\Model\Table\OauthScopesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Model\Table\OauthScopesTable Test Case
 */
class OauthScopesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Skeleton\Model\Table\OauthScopesTable
     */
    public $OauthScopes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OauthScopes',
        'app.OauthAccessTokens',
        'app.OauthAuthorizationCodes',
        'app.OauthClients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OauthScopes') ? [] : ['className' => OauthScopesTable::class];
        $this->OauthScopes = TableRegistry::getTableLocator()->get('OauthScopes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OauthScopes);

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
