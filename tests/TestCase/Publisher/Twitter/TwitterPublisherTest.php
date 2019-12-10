<?php
namespace Qobo\Social\Test\TestCase\Publisher\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Qobo\Social\Model\Entity\Post;
use Qobo\Social\Model\Table\AccountsTable;
use Qobo\Social\Model\Table\NetworksTable;
use Qobo\Social\Model\Table\PostsTable;
use Qobo\Social\Test\App\Publisher\Twitter\TwitterPublisher;

/**
 * Qobo\Social\Publisher\Twitter\TwitterPublisher Test Case
 */
class TwitterPublisherTest extends TestCase
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
     * @var \Qobo\Social\Model\Table\NetworksTable
     */
    public $Networks;

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
        'plugin.qobo/social.accounts',
        'plugin.qobo/social.networks',
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

        $config = TableRegistry::getTableLocator()->exists('Posts') ? [] : ['className' => PostsTable::class];
        /** @var \Qobo\Social\Model\Table\PostsTable $table */
        $table = TableRegistry::getTableLocator()->get('Posts', $config);
        $this->Posts = $table;

        $config = TableRegistry::getTableLocator()->exists('Accounts') ? [] : ['className' => AccountsTable::class];
        /** @var \Qobo\Social\Model\Table\AccountsTable $table */
        $table = TableRegistry::getTableLocator()->get('Accounts', $config);
        $this->Accounts = $table;

        $config = TableRegistry::getTableLocator()->exists('Networks') ? [] : ['className' => NetworksTable::class];
        /** @var \Qobo\Social\Model\Table\NetworksTable $table */
        $table = TableRegistry::getTableLocator()->get('Networks', $config);
        $this->Networks = $table;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Accounts);
        unset($this->Networks);
        unset($this->Posts);

        parent::tearDown();
    }

    /**
     * Test getClient method
     *
     * @return void
     */
    public function testGetClient(): void
    {
        $publisher = new TwitterPublisher();
        $account = $this->Accounts->get('00000000-0000-0000-0000-000000000001');
        $network = $this->Networks->get('00000000-0000-0000-0000-000000000001');
        $publisher->setAccount($account);
        $publisher->setNetwork($network);
        $client = $publisher->getClient();
        $this->assertInstanceOf(TwitterOAuth::class, $client);
    }

    /**
     * Test publish method
     *
     * @return void
     */
    public function testPublisherPublish(): void
    {
        $publisher = new TwitterPublisher();
        $response = $publisher->publish($this->createPost());
        $this->assertEquals('1000000000000000333', $response->getExternalPostId());
    }

    /**
     * Test response errors
     *
     * @return void
     */
    public function testPublisherErrors(): void
    {
        $publisher = new TwitterPublisher();
        $publisher->filename = 'twitter_response_publisher_bad_request';
        $response = $publisher->publish($this->createPost());
        $this->assertTrue($response->hasErrors());
        $this->assertCount(1, $response->getErrors());
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
