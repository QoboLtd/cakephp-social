<?php
namespace Qobo\Social\Test\TestCase\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
use Qobo\Social\Model\Entity\Post;
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
        $validator = new Validator();
        $result = $this->Posts->validationDefault($validator);
        $this->assertInstanceOf(Validator::class, $result);
    }

    /**
     * Test validationCanAccountPost method
     *
     * @return void
     */
    public function testValidationCanAccountPost(): void
    {
        $validator = new Validator();
        $result = $this->Posts->validationCanAccountPost($validator);
        $this->assertInstanceOf(Validator::class, $result);

        $post = $this->Posts->newEntity();
        $data = [
            'account_id' => '00000000-0000-0000-0000-000000000002',
        ];
        $post = $this->Posts->patchEntity($post, $data, ['validate' => 'canAccountPost']);
        $errors = $post->getError('account_id');
        $this->assertNotEmpty($errors);
        $this->assertArrayHasKey('can-post', $errors);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $rules = new RulesChecker();
        $result = $this->Posts->buildRules($rules);
        $this->assertInstanceOf(RulesChecker::class, $result);
    }
    /**
     * Helper function which creates a Post entity.
     *
     * @param mixed[] $fields Fields.
     * @return \Qobo\Social\Model\Entity\Post Post entity.
     */
    protected function createPost(array $fields = []): Post
    {
        $post = $this->Posts->newEntity($fields + [
            'account_id' => '00000000-0000-0000-0000-000000000001',
            'type' => 'foobar',
            'url' => 'https://google.com',
            'subject' => 'Foo',
            'content' => 'Bar',
        ]);

        return $post;
    }
}
