<?php
namespace Qobo\Social\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Qobo\Social\Model\Table\PostsTable;

/**
 * Qobo\Social\Model\Table\PostsTable Test Case
 */
class PostsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Social\Model\Table\PostsTable
     */
    public $Posts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/social.posts',
        'plugin.qobo/social.accounts',
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
        $config = TableRegistry::getTableLocator()->exists('Posts') ? [] : ['className' => PostsTable::class];
        /** @var \Qobo\Social\Model\Table\PostsTable $table */
        $table = TableRegistry::getTableLocator()->get('Posts', $config);
        $this->Posts = $table;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Posts);

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
