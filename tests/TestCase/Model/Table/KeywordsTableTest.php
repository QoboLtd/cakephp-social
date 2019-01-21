<?php
namespace Qobo\Social\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Qobo\Social\Model\Table\KeywordsTable;

/**
 * Qobo\Social\Model\Table\KeywordsTable Test Case
 */
class KeywordsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Social\Model\Table\KeywordsTable
     */
    public $Keywords;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/social.keywords',
        'plugin.qobo/social.topics'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Keywords') ? [] : ['className' => KeywordsTable::class];
        $this->Keywords = TableRegistry::getTableLocator()->get('Keywords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Keywords);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
