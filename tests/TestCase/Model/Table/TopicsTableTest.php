<?php
namespace Qobo\Social\Test\TestCase\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
use Qobo\Social\Model\Table\TopicsTable;

/**
 * Qobo\Social\Model\Table\TopicsTable Test Case
 */
class TopicsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Social\Model\Table\TopicsTable
     */
    public $Topics;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/social.topics',
        'plugin.qobo/social.keywords',
        'plugin.qobo/social.posts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Topics') ? [] : ['className' => TopicsTable::class];
        /** @var \Qobo\Social\Model\Table\TopicsTable $table */
        $table = TableRegistry::getTableLocator()->get('Topics', $config);
        $this->Topics = $table;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Topics);

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
        $result = $this->Topics->validationDefault($validator);
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
        $result = $this->Topics->buildRules($rules);
        $this->assertInstanceOf(RulesChecker::class, $result);
    }
}
