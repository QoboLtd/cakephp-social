<?php
namespace Qobo\Social\Test\TestCase\Provider\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use InvalidArgumentException;
use Qobo\Social\Model\Entity\Post;
use Qobo\Social\Model\Table\NetworksTable;
use Qobo\Social\Model\Table\PostsTable;
use Qobo\Social\Model\Table\TopicsTable;
use Qobo\Social\Provider\ProviderRegistry;
use Qobo\Social\Provider\Twitter\TwitterResponse;
use Qobo\Social\Test\App\Provider\Twitter\TwitterPremiumSearchProvider;
use stdClass;

/**
 * Qobo\Social\Provider\Twitter\TwitterPremiumSearchProvider Test Case
 */
class TwitterPremiumSearchProviderTest extends TestCase
{

    /**
     * Networks table
     *
     * @var \Qobo\Social\Model\Table\NetworksTable
     */
    public $Networks;

    /**
     * Topics table
     *
     * @var \Qobo\Social\Model\Table\TopicsTable
     */
    public $Topics;

    /**
     * Posts table
     *
     * @var \Qobo\Social\Model\Table\PostsTable
     */
    public $Posts;

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
        'plugin.qobo/social.accounts',
        'plugin.qobo/social.networks',
        'plugin.qobo/social.posts',
        'plugin.qobo/social.posts_topics',
        'plugin.qobo/social.topics',
        'plugin.qobo/social.keywords',
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

        $config = TableRegistry::getTableLocator()->exists('Topics') ? [] : ['className' => TopicsTable::class];
        /** @var \Qobo\Social\Model\Table\TopicsTable $table */
        $table = TableRegistry::getTableLocator()->get('Topics', $config);
        $this->Topics = $table;

        $config = TableRegistry::getTableLocator()->exists('Posts') ? [] : ['className' => PostsTable::class];
        /** @var \Qobo\Social\Model\Table\PostsTable $table */
        $table = TableRegistry::getTableLocator()->get('Posts', $config);
        $this->Posts = $table;

        $this->Registry = ProviderRegistry::getInstance();
        $this->Registry->set('twitter', '30day-dev', [
            'className' => TwitterPremiumSearchProvider::class,
            'config' => [
                'env' => 'dev',
                'filename' => 'twitter_response'
            ],
        ]);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        $this->Registry->clear();
        unset($this->Networks);
        unset($this->Topics);
        unset($this->Registry);

        parent::tearDown();
    }

    /**
     * Test client getter
     *
     * @return void
     */
    public function testGetClient(): void
    {
        /** @var \Qobo\Social\Model\Entity\Network $network */
        $network = $this->Networks->find('all')->where(['name' => 'twitter'])->first();
        /** @var \Qobo\Social\Provider\Twitter\TwitterPremiumSearchProvider $provider */
        $provider = $network->getSocialProvider('30day-dev');
        $client = $provider->getClient();
        $this->assertInstanceOf(TwitterOAuth::class, $client);
    }

    /**
     * Test invalid archive types
     *
     * @return void
     */
    public function testInvalidArchiveType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $archiveType = 'invalid';

        /** @var \Qobo\Social\Model\Entity\Network $network */
        $network = $this->Networks->find('all')->where(['name' => 'twitter'])->first();
        /** @var \Qobo\Social\Provider\Twitter\TwitterPremiumSearchProvider $provider */
        $provider = $network->getSocialProvider('30day-dev');
        $provider->setConfig([
            'env' => 'dev',
            'archiveType' => $archiveType,
        ]);
        $provider->setTopic($this->Topics->newEntity());

        try {
            $provider->read();
        } catch (InvalidArgumentException $e) {
            $this->assertContains("The archive type `{$archiveType}` is not valid", $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test environment config parameter is mandatory
     *
     * @return void
     */
    public function testEnvironmentParameterMandatory(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /** @var \Qobo\Social\Model\Entity\Network $network */
        $network = $this->Networks->find('all')->where(['name' => 'twitter'])->first();
        /** @var \Qobo\Social\Provider\Twitter\TwitterPremiumSearchProvider $provider */
        $provider = $network->getSocialProvider('30day-dev');
        $provider->setTopic($this->Topics->newEntity());
        $provider->setConfig([
            'env' => '',
        ]);

        try {
            $provider->read();
        } catch (InvalidArgumentException $e) {
            $this->assertContains('environment parameter is mandatory', $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test read tweets and post entites.
     *
     * @return void
     */
    public function testReadPosts(): void
    {
        /** @var \Qobo\Social\Model\Entity\Network $network */
        $network = $this->Networks->find('all')->where(['name' => 'twitter'])->first();
        /** @var \Cake\ORM\Query $query */
        $query = $this->Topics->find('all')->contain(['Keywords']);
        /** @var \Qobo\Social\Model\Entity\Topic $topic */
        $topic = $query->first();
        /** @var \Qobo\Social\Provider\Twitter\TwitterPremiumSearchProvider $provider */
        $provider = $network->getSocialProvider('30day-dev');
        $provider->setTopic($topic);
        $results = $provider->read();
        $this->assertInstanceOf(TwitterResponse::class, $results);
        $this->assertInstanceOf(stdClass::class, $results->getPayload());

        $posts = $results->getPosts();
        $this->assertCount(3, $posts);
        $this->assertAllInstanceOf(Post::class, $posts);

        /** @var \Cake\ORM\ResultSet&iterable<\Cake\Datasource\EntityInterface> $savePosts */
        $savePosts = $posts;
        $this->Posts->saveMany($savePosts);

        // The second call to `ResponseInterface::getPosts` should return no rows
        // since they were already saved
        $posts = $results->getPosts();
        $this->assertEmpty($posts);
    }

    /**
     * Test read empty results
     *
     * @return void
     */
    public function testReadEmptyResults(): void
    {
        /** @var \Qobo\Social\Model\Entity\Network $network */
        $network = $this->Networks->find('all')->where(['name' => 'twitter'])->first();
        /** @var \Cake\ORM\Query $query */
        $query = $this->Topics->find('all')->contain(['Keywords']);
        /** @var \Qobo\Social\Model\Entity\Topic $topic */
        $topic = $query->first();
        /** @var \Qobo\Social\Provider\Twitter\TwitterPremiumSearchProvider $provider */
        $provider = $network->getSocialProvider('30day-dev');
        $provider->setTopic($topic);
        $provider->setConfig(['filename' => 'twitter_response_no_results']);
        $results = $provider->read();
        $this->assertInstanceOf(TwitterResponse::class, $results);
        $this->assertEmpty($results->getPosts());
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
}
