<?php
namespace Qobo\Social\Test\TestCase\Shell\Task;

use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOutput;
use Cake\Console\Exception\StopException;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Qobo\Social\Model\Table\NetworksTable;
use Qobo\Social\Model\Table\PostsTable;
use Qobo\Social\Model\Table\TopicsTable;
use Qobo\Social\Provider\ProviderRegistry;
use Qobo\Social\Shell\Task\ImportTask;
use Qobo\Social\Test\App\Provider\TestProvider;

class ImportTaskTest extends TestCase
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
        'plugin.qobo/social.keywords',
        'plugin.qobo/social.networks',
        'plugin.qobo/social.posts',
        'plugin.qobo/social.posts_topics',
        'plugin.qobo/social.topics',
    ];

    /**
     * @var \Qobo\Social\Shell\Task\ImportTask
     */
    protected $Task;

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
        $this->Registry->set('twitter', 'my-provider', [
            'className' => TestProvider::class,
            'config' => [
                'foo' => 'baz',
            ],
        ]);

        /** @var \Cake\Console\ConsoleOutput $errIo */
        $errIo = $this->getMockBuilder('Cake\Console\ConsoleOutput')->getMock();
        /** @var \Cake\Console\ConsoleIo */
        $io = new ConsoleIo(new ConsoleOutput(), $errIo);
        $io->level(ConsoleIo::QUIET);

        $this->Task = new ImportTask($io);
        $this->Task->initialize();
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
        unset($this->Task);

        parent::tearDown();
    }

    /**
     * Test passing invalid network
     *
     * @return void
     */
    public function testInvalidNetworkName(): void
    {
        $this->expectException(StopException::class);
        $name = 'invalid-network';
        try {
            $this->Task->main($name, '');
        } catch (StopException $e) {
            $this->assertEquals("Network `{$name}` is not defined in the system.", $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test passing invalid provider
     *
     * @return void
     */
    public function testInvalidNetworkProviderName(): void
    {
        $this->expectException(StopException::class);
        $name = 'invalid-provider';
        try {
            $this->Task->main('twitter', $name);
        } catch (StopException $e) {
            $this->assertEquals("`{$name}` is not a valid social provider.", $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test passing invalid topic
     *
     * @return void
     */
    public function testInvalidTopicName(): void
    {
        $this->expectException(StopException::class);
        $name = 'invalid-topic';
        try {
            $this->Task->main('twitter', 'my-provider', $name);
        } catch (StopException $e) {
            $this->assertEquals("Topic `{$name}` is not defined in the system.", $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test main
     *
     * @return void
     */
    public function testRunMain(): void
    {
        $posts = $this->Posts->find('all');
        $this->assertCount(2, $posts);

        $network = 'twitter';
        $provider = 'my-provider';
        $topic = '00000000-0000-0000-0000-000000000001';
        $this->Task->main($network, $provider, $topic);

        $posts = $this->Posts->find('all');
        $this->assertCount(3, $posts);
    }
}
