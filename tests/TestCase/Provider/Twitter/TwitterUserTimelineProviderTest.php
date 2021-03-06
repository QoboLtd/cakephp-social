<?php
namespace Qobo\Social\Test\TestCase\Provider\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use InvalidArgumentException;
use Qobo\Social\Model\Entity\Post;
use Qobo\Social\Model\Table\AccountsTable;
use Qobo\Social\Model\Table\NetworksTable;
use Qobo\Social\Provider\Twitter\TwitterResponse;
use Qobo\Social\Provider\Twitter\TwitterUserTimelineProvider;
use Webmozart\Assert\Assert;

/**
 * Qobo\Social\Provider\Twitter\TwitterUserTimelineProvider Test Case
 */
class TwitterUserTimelineProviderTest extends TestCase
{

    /**
     * Networks table
     *
     * @var \Qobo\Social\Model\Table\NetworksTable
     */
    public $Networks;

    /**
     * Accounts table
     *
     * @var \Qobo\Social\Model\Table\AccountsTable
     */
    public $Accounts;

    /**
     * Test subject
     *
     * @var \Qobo\Social\Provider\ProviderRegistry
     */
    public $Registry;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Qobo/Social.Accounts',
        'plugin.Qobo/Social.InteractionTypes',
        'plugin.Qobo/Social.Keywords',
        'plugin.Qobo/Social.Networks',
        'plugin.Qobo/Social.PostInteractions',
        'plugin.Qobo/Social.Posts',
        'plugin.Qobo/Social.PostsTopics',
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

        $config = TableRegistry::getTableLocator()->exists('Networks') ? [] : ['className' => NetworksTable::class];
        /** @var \Qobo\Social\Model\Table\NetworksTable $table */
        $table = TableRegistry::getTableLocator()->get('Networks', $config);
        $this->Networks = $table;

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
        unset($this->Accounts);

        parent::tearDown();
    }

    /**
     * Test client getter
     *
     * @return void
     */
    public function testGetClient(): void
    {
        $provider = $this->getProviderMock();
        $client = $provider->getClient();
        $this->assertInstanceOf(TwitterOAuth::class, $client);
    }

    /**
     * Test missing account parameter
     *
     * @return void
     */
    public function testAccountIdMandatoryParameter(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $provider = $this->getProviderMock();

        try {
            $provider->read();
        } catch (InvalidArgumentException $e) {
            $this->assertContains("`accountId` is a mandatory parameter", $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test missing account
     *
     * @return void
     */
    public function testMissingAccount(): void
    {
        $this->expectException(RecordNotFoundException::class);
        $accountId = '00000000-0000-0000-0000-000000000009';
        $provider = $this->getProviderMock();
        $provider->read(compact('accountId'));
    }

    /**
     * Test missing account parameter
     *
     * @return void
     */
    public function testAccountIdCredentialsAreEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $provider = $this->getProviderMock();
        $account = $this->Accounts->newEntity([
            'network_id' => '00000000-0000-0000-0000-000000000001',
            'handle' => 'user_with_no_credentials',
            'active' => true,
            'is_ours' => true,
            'credentials' => '',
        ]);
        $this->Accounts->save($account);

        try {
            $provider->read(['accountId' => $account->id]);
        } catch (InvalidArgumentException $e) {
            $this->assertContains("Account is missing credentials", $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test missing account parameter
     *
     * @return void
     */
    public function testAccountIdCredentialsNotEmptyButMissinSomeValues(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $provider = $this->getProviderMock();
        $account = $this->Accounts->newEntity([
            'network_id' => '00000000-0000-0000-0000-000000000001',
            'handle' => 'user_with_no_credentials',
            'active' => true,
            'is_ours' => true,
            'credentials' => json_encode(['foo' => 'bar']),
        ], ['accessibleFields' => ['credentials' => true]]);
        $this->Accounts->save($account);

        try {
            $provider->read(['accountId' => $account->id]);
        } catch (InvalidArgumentException $e) {
            $this->assertContains("Invalid twitter credentials stored in database", $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test read with no results
     *
     * @return void
     */
    public function testReadNoResults(): void
    {
        $provider = $this->getProviderMock('twitter_response_user_timeline_no_results');
        $account = $this->Accounts->newEntity([
            'network_id' => '00000000-0000-0000-0000-000000000001',
            'handle' => 'user_with_no_credentials',
            'active' => true,
            'is_ours' => true,
            'credentials' => json_encode([
                'oauth_token' => 'oauth_token',
                'oauth_token_secret' => 'oauth_token',
                'user_id' => '1000001',
            ]),
        ], ['accessibleFields' => ['credentials' => true]]);
        $this->Accounts->save($account);

        $results = $provider->read(['accountId' => $account->id]);
        $this->assertInstanceOf(TwitterResponse::class, $results);

        $posts = $results->getPosts();
        $this->assertEmpty($posts);
    }

    /**
     * Test read
     *
     * @return void
     */
    public function testReadSuccess(): void
    {
        $provider = $this->getProviderMock();
        $account = $this->Accounts->newEntity([
            'network_id' => '00000000-0000-0000-0000-000000000001',
            'handle' => 'user_with_no_credentials',
            'active' => true,
            'is_ours' => true,
            'credentials' => json_encode([
                'oauth_token' => 'oauth_token',
                'oauth_token_secret' => 'oauth_token',
                'user_id' => '1000001',
            ]),
        ], ['accessibleFields' => ['credentials' => true]]);
        $this->Accounts->save($account);

        $results = $provider->read(['accountId' => $account->id]);
        $this->assertInstanceOf(TwitterResponse::class, $results);

        $posts = $results->getPosts();
        $this->assertCount(1, $posts);
        $this->assertAllInstanceOf(Post::class, $posts);
    }

    /**
     * Helper function to assert instance of all objects in an array.
     *
     * @param string $expected Expected class
     * @param mixed[] $actual Array of objects
     * @param string $message Error message
     */
    protected function assertAllInstanceOf(string $expected, array $actual, string $message = ''): void
    {
        foreach ($actual as $class) {
            $this->assertInstanceOf($expected, $class, $message);
        }
    }

    /**
     * Returns the twitter timeline provider mock.
     *
     * @param string $responseFile Name of response file.
     * @return \Qobo\Social\Provider\Twitter\TwitterUserTimelineProvider
     */
    protected function getProviderMock(string $responseFile = 'twitter_response_user_timeline'): TwitterUserTimelineProvider
    {
        $fileContents = (string)file_get_contents(TESTS . 'data' . DS . $responseFile . '.json');
        $response = json_decode($fileContents);
        /** @var \PHPUnit\Framework\MockObject\MockObject&\Qobo\Social\Provider\Twitter\TwitterUserTimelineProvider $provider */
        $provider = $this->getMockBuilder(TwitterUserTimelineProvider::class)
            ->setMethods(['callApi'])
            ->getMock();
        $provider->expects($this->any())
            ->method('callApi')
            ->will($this->returnValue($response));
        Assert::isInstanceOf($provider, TwitterUserTimelineProvider::class);
        /** @var \Qobo\Social\Model\Entity\Network $network */
        $network = $this->Networks->find('all')->where(['name' => 'twitter'])->first();
        $provider->setNetwork($network);
        $provider->setCredentials($network->oauth_consumer_key, $network->oauth_consumer_key);

        return $provider;
    }
}
