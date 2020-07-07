<?php
namespace Qobo\Social\Test\TestCase\Model\Table;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
use Qobo\Social\Model\Entity\Post;
use Qobo\Social\Model\Table\AccountsTable;
use Qobo\Social\Model\Table\PostsTable;
use Qobo\Social\Test\App\Publisher\BadPublisher;
use Qobo\Social\Test\App\Publisher\PublisherThrows;
use Qobo\Social\Test\App\Publisher\Twitter\TwitterPublisher;

/**
 * Qobo\Social\Model\Table\PostsTable Test Case
 */
class PostsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Social\Model\Table\AccountsTable
     */
    public $Accounts;

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
        'plugin.Qobo/Social.Accounts',
        'plugin.Qobo/Social.Networks',
        'plugin.Qobo/Social.Posts',
        'plugin.Qobo/Social.Topics',
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

        $config = TableRegistry::getTableLocator()->exists('Accounts') ? [] : ['className' => AccountsTable::class];
        /** @var \Qobo\Social\Model\Table\AccountsTable $table */
        $table = TableRegistry::getTableLocator()->get('Accounts', $config);
        $this->Accounts = $table;
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
     * Test validationPublish method
     *
     * @return void
     */
    public function testValidationPublish(): void
    {
        $validator = new Validator();
        $result = $this->Posts->validationPublish($validator);
        $this->assertInstanceOf(Validator::class, $result);

        $post = $this->Posts->newEntity();
        $data = [
            'account_id' => '00000000-0000-0000-0000-000000000002',
        ];
        $post = $this->Posts->patchEntity($post, $data, ['validate' => 'publish']);
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
     * Test afterSave
     *
     * @return void
     */
    public function testAfterSaveEvent(): void
    {
        /** @var \Qobo\Social\Model\Table\PostsTable&\PHPUnit\Framework\MockObject\MockObject mock */
        $mock = $this->getMockForModel('Qobo/Social.Posts', ['runPublisher']);
        $mock->expects($this->once())
            ->method('runPublisher')
            ->will($this->returnValue(true));
        $post = $this->createPost();
        $options = new ArrayObject();
        $event = new Event('Model.afterSave', $mock, compact('post', 'options'));
        $mock->afterSave($event, $post, $options);
    }

    /**
     * Test afterSave
     *
     * @return void
     */
    public function testAfterSaveEventDisabled(): void
    {
        Configure::write('Qobo/Social.publishEnabled', false);
        /** @var \Qobo\Social\Model\Table\PostsTable&\PHPUnit\Framework\MockObject\MockObject mock */
        $mock = $this->getMockForModel('Qobo/Social.Posts', ['runPublisher']);
        $mock->expects($this->never())
            ->method('runPublisher')
            ->will($this->returnValue(true));
        $post = $this->createPost();
        $options = new ArrayObject();
        $event = new Event('Model.afterSave', $mock, compact('post', 'options'));
        $mock->afterSave($event, $post, $options);
    }

    /**
     * Test missing account
     *
     * @return void
     */
    public function testAccountMissing(): void
    {
        $this->expectException(RecordNotFoundException::class);
        $post = $this->createPost(['account_id' => 'bad_id']);
        $options = new ArrayObject();
        $event = new Event('Model.afterSave', $this->Posts, compact('post', 'options'));
        try {
            $this->Posts->afterSave($event, $post, $options);
        } catch (RecordNotFoundException $e) {
            $this->assertContains('qobo_social_accounts', $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test account is not ours
     *
     * @return void
     */
    public function testAccountNotOurs(): void
    {
        $post = $this->createPost(['account_id' => '00000000-0000-0000-0000-000000000002']);
        $expected = clone $post;
        $options = new ArrayObject();
        $event = new Event('Model.afterSave', $this->Posts, compact('post', 'options'));
        $this->Posts->afterSave($event, $post, $options);
        $this->assertEquals($expected, $post);
    }

    /**
     * Test network is missing
     *
     * @return void
     */
    public function testNetworkMissing(): void
    {
        $this->expectException(RecordNotFoundException::class);
        $post = $this->createPost(['account_id' => '00000000-0000-0000-0000-000000000003']);
        $expected = clone $post;
        $options = new ArrayObject();
        $event = new Event('Model.afterSave', $this->Posts, compact('post', 'options'));
        try {
            $this->Posts->afterSave($event, $post, $options);
        } catch (RecordNotFoundException $e) {
            $this->assertContains('qobo_social_networks', $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test when publisher class is invalid the event exists gracefully
     *
     * @return void
     */
    public function testPublisherNotFoundGracefulExit(): void
    {
        Configure::write('Qobo/Social.publisher.twitter', 'Some\Bad\Class');
        $post = $this->createPost(['account_id' => '00000000-0000-0000-0000-000000000001']);
        $expected = clone $post;
        $options = new ArrayObject();
        $event = new Event('Model.afterSave', $this->Posts, compact('post', 'options'));
        $this->Posts->afterSave($event, $post, $options);
        $this->assertEquals($expected, $post);
    }

    /**
     * Test when publisher class is not a valid publisher
     *
     * @return void
     */
    public function testPublisherBadInterface(): void
    {
        Configure::write('Qobo/Social.publisher.twitter', BadPublisher::class);
        $post = $this->createPost(['account_id' => '00000000-0000-0000-0000-000000000001']);
        $expected = clone $post;
        $options = new ArrayObject();
        $event = new Event('Model.afterSave', $this->Posts, compact('post', 'options'));
        $this->Posts->afterSave($event, $post, $options);
        $this->assertEquals($expected, $post);
    }

    /**
     * Test successful publisher execution
     *
     * @return void
     */
    public function testPublisherSuccess(): void
    {
        Configure::write('Qobo/Social.publisher.twitter', TwitterPublisher::class);
        $post = $this->createPost(['account_id' => '00000000-0000-0000-0000-000000000001']);
        $original = clone $post;
        $options = new ArrayObject();
        $event = new Event('Model.afterSave', $this->Posts, compact('post', 'options'));
        $this->Posts->afterSave($event, $post, $options);
        $this->assertNotEquals($original, $post);
        $this->assertEquals('1000000000000000333', $post->get('external_post_id'));
    }

    /**
     * Test publisher exceptions are handled gracefully
     *
     * @return void
     */
    public function testPublisherExceptionIsHandled(): void
    {
        Configure::write('Qobo/Social.publisher.twitter', PublisherThrows::class);
        $post = $this->createPost(['account_id' => '00000000-0000-0000-0000-000000000001']);
        $expected = clone $post;
        $options = new ArrayObject();
        $event = new Event('Model.afterSave', $this->Posts, compact('post', 'options'));
        $this->Posts->afterSave($event, $post, $options);
        $this->assertEquals($expected, $post);
        $this->assertNull($post->get('external_post_id'));
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
