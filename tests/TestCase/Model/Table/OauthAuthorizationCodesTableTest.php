<?php
namespace Skeleton\Test\TestCase\Model\Table;

use Skeleton\Model\Table\OauthAuthorizationCodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Skeleton\Model\Table\OauthAuthorizationCodesTable Test Case
 */
class OauthAuthorizationCodesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Skeleton\Model\Table\OauthAuthorizationCodesTable
     */
    public $OauthAuthorizationCodes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OauthAuthorizationCodes',
        'app.Users',
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
        $config = TableRegistry::getTableLocator()->exists('OauthAuthorizationCodes') ? [] : ['className' => OauthAuthorizationCodesTable::class];
        $this->OauthAuthorizationCodes = TableRegistry::getTableLocator()->get('OauthAuthorizationCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OauthAuthorizationCodes);

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
