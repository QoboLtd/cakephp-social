<?php
namespace Qobo\Social\Test\TestCase\Publisher;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Qobo\Social\Model\Entity\Account;
use Qobo\Social\Model\Entity\Network;
use Qobo\Social\Model\Entity\Post;
use Qobo\Social\Model\Table\AccountsTable;
use Qobo\Social\Model\Table\NetworksTable;
use Qobo\Social\Model\Table\PostsTable;
use Qobo\Social\Publisher\PublisherResponseInterface;
use Qobo\Social\Test\App\Publisher\TestPublisher;

/**
 * Qobo\Social\Publisher\AbstractPublisher Test Case
 */
class AbstractPublisherTest extends TestCase
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
        unset($this->Posts);

        parent::tearDown();
    }

    /**
     * Test response payload
     *
     * @return void
     */
    public function testPublisherResponse(): void
    {
        $publisher = new TestPublisher();
        $response = $publisher->publish($this->createPost());
        $this->assertInstanceOf(PublisherResponseInterface::class, $response);

        $payload = $response->getResponsePayload();
        $this->assertNotEmpty($payload);
        $this->assertFalse($response->hasErrors());
        $this->assertCount(0, $response->getErrors());
    }

    /**
     * Test setters and getters
     *
     * @return void
     */
    public function testSettersGetters(): void
    {
        $publisher = new TestPublisher();
        $network = $this->Networks->get('00000000-0000-0000-0000-000000000001');
        $publisher->setNetwork($network);
        $this->assertInstanceOf(Network::class, $publisher->getNetwork());

        $account = $this->Accounts->get('00000000-0000-0000-0000-000000000001');
        $publisher->setAccount($account);
        $this->assertInstanceOf(Account::class, $publisher->getAccount());
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
