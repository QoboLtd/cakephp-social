<?php
namespace Qobo\Social\Test\TestCase\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
use Qobo\Social\Model\Table\InteractionTypesTable;

/**
 * Qobo\Social\Model\Table\InteractionTypesTable Test Case
 */
class InteractionTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Social\Model\Table\InteractionTypesTable
     */
    public $InteractionTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/social.interaction_types',
        'plugin.qobo/social.networks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('InteractionTypes') ? [] : ['className' => InteractionTypesTable::class];
        /** @var \Qobo\Social\Model\Table\InteractionTypesTable $table */
        $table = TableRegistry::getTableLocator()->get('InteractionTypes', $config);
        $this->InteractionTypes = $table;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InteractionTypes);

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
        $result = $this->InteractionTypes->validationDefault($validator);
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
        $result = $this->InteractionTypes->buildRules($rules);
        $this->assertInstanceOf(RulesChecker::class, $result);
    }
}
