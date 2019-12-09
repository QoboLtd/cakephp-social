<?php
namespace Qobo\Social\Test\TestCase\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
use Qobo\Social\Model\Table\PostsTopicsTable;

/**
 * Qobo\Social\Model\Table\PostsTopicsTable Test Case
 */
class PostsTopicsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Social\Model\Table\PostsTopicsTable
     */
    public $PostsTopics;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/social.posts_topics',
        'plugin.qobo/social.posts',
        'plugin.qobo/social.topics',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PostsTopics') ? [] : ['className' => PostsTopicsTable::class];
        /** @var \Qobo\Social\Model\Table\PostsTopicsTable $table */
        $table = TableRegistry::getTableLocator()->get('PostsTopics', $config);
        $this->PostsTopics = $table;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PostsTopics);

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
        $validator = new Validator();
        $result = $this->PostsTopics->validationDefault($validator);
        $this->assertInstanceOf(Validator::class, $result);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $rules = new RulesChecker();
        $result = $this->PostsTopics->buildRules($rules);
        $this->assertInstanceOf(RulesChecker::class, $result);
    }
}
