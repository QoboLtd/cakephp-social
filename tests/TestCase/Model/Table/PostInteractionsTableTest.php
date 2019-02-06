<?php
namespace Qobo\Social\Test\TestCase\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
use Qobo\Social\Model\Table\PostInteractionsTable;

/**
 * Qobo\Social\Model\Table\PostInteractionsTable Test Case
 */
class PostInteractionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Social\Model\Table\PostInteractionsTable
     */
    public $PostInteractions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/social.post_interactions',
        'plugin.qobo/social.posts',
        'plugin.qobo/social.interaction_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PostInteractions') ? [] : ['className' => PostInteractionsTable::class];
        /** @var \Qobo\Social\Model\Table\PostInteractionsTable $table */
        $table = TableRegistry::getTableLocator()->get('PostInteractions', $config);
        $this->PostInteractions = $table;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PostInteractions);

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
        $result = $this->PostInteractions->validationDefault($validator);
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
        $result = $this->PostInteractions->buildRules($rules);
        $this->assertInstanceOf(RulesChecker::class, $result);
    }
}
