<?php
namespace Qobo\Social\Test\TestCase\Provider;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use InvalidArgumentException;
use Qobo\Social\Model\Table\NetworksTable;
use Qobo\Social\Provider\ProviderInterface;
use Qobo\Social\Provider\ProviderRegistry;
use Qobo\Social\Test\App\Provider\TestProvider;

/**
 * Qobo\Social\Provider\ProvderRegistry Test Case
 */
class ProviderRegistryTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Social\Model\Table\NetworksTable
     */
    public $Networks;

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
        $config = TableRegistry::getTableLocator()->exists('Networks') ? [] : ['className' => NetworksTable::class];
        /** @var \Qobo\Social\Model\Table\NetworksTable $table */
        $table = TableRegistry::getTableLocator()->get('Networks', $config);
        $this->Networks = $table;

        $this->Registry = ProviderRegistry::getInstance();
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
        unset($this->Registry);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInstance(): void
    {
        $firstCall = ProviderRegistry::getInstance();
        $secondCall = ProviderRegistry::getInstance();

        $this->assertInstanceOf(ProviderRegistry::class, $firstCall);
        $this->assertSame($firstCall, $secondCall);
    }

    /**
     * Test a successful set and get
     */
    public function testSetGetSuccess(): void
    {
        $this->Registry->set('twitter', 'test', TestProvider::class);
        $provider = $this->Registry->get('twitter', 'test');
        $this->assertInstanceOf(ProviderInterface::class, $provider);
    }

    /**
     * Test provider config
     */
    public function testProviderWithConfig(): void
    {
        $expected = 'baz';
        $this->Registry->set('twitter', 'test', [
            'className' => TestProvider::class,
            'config' => [
                'foo' => $expected,
            ],
        ]);

        /** @var \Qobo\Social\Test\App\Provider\TestProvider $provider */
        $provider = $this->Registry->get('twitter', 'test');
        $actual = $provider->getConfig('foo');
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test when a duplicate provider name for a given network is passed
     */
    public function testAlreadySetNoOverwrite(): void
    {
        $this->expectException(InvalidArgumentException::class);

        try {
            $this->Registry->set('twitter', 'test', TestProvider::class);
            $this->Registry->set('twitter', 'test', TestProvider::class);
        } catch (InvalidArgumentException $e) {
            $this->assertContains('Provider `test` for network `twitter` has already been registered', $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test when a provider parameter is of invalid type
     */
    public function testProviderConfigInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        try {
            /** @var string $badType */
            $badType = 123;
            $this->Registry->set('twitter', 'test', $badType);
        } catch (InvalidArgumentException $e) {
            $this->assertContains('Provider must be a string class name, or array of class name and config', $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test provider array passed without class name
     */
    public function testProviderConfigArrayWithoutClassName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $class = '';

        try {
            $this->Registry->set('twitter', 'test', ['clsName' => TestProvider::class]);
        } catch (InvalidArgumentException $e) {
            $this->assertContains("Provider class `$class` does not exist.", $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test an invalid class name passed
     */
    public function testProviderConfigInvalidClass(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $class = 'SomeBadClass';

        try {
            $this->Registry->set('twitter', 'test', $class);
        } catch (InvalidArgumentException $e) {
            $this->assertContains("Provider class `$class` does not exist.", $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test get invalid provider name
     */
    public function testGetInvalidProviderName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        try {
            $this->Registry->get('twitter', 'test');
        } catch (InvalidArgumentException $e) {
            $this->assertContains("Provider `test` for network `twitter` is not registered.", $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test passing network entity
     */
    public function testPassNetworkEntity(): void
    {
        /** @var \Qobo\Social\Model\Entity\Network $network */
        $network = $this->Networks->find('all')->where(['name' => 'twitter'])->first();
        $this->assertNotNull($network);

        $this->Registry->set($network, 'test', TestProvider::class);
        $provider = $this->Registry->get('twitter', 'test');
        $this->assertInstanceOf(ProviderInterface::class, $provider);
    }

    /**
     * Test invalid type as network entity
     */
    public function testPassInvalidNetworkType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /** @var \Qobo\Social\Model\Entity\Network $network */
        $network = 123;

        try {
            $this->Registry->set($network, 'test', TestProvider::class);
        } catch (InvalidArgumentException $e) {
            $this->assertContains("Network must be a string or", $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test pass missing network name
     */
    public function testPassMissingNetworkName(): void
    {
        $this->expectException(RecordNotFoundException::class);
        $networkName = 'bad-network';
        $this->Registry->set($networkName, 'test', TestProvider::class);
    }

    /**
     * Test remove provider
     */
    public function testRemoveProvider(): void
    {
        $this->Registry->set('twitter', 'test', TestProvider::class);
        $exists = $this->Registry->exists('twitter', 'test');
        $this->assertTrue($exists);

        $this->Registry->remove('twitter', 'test');
        $exists = $this->Registry->exists('twitter', 'test');
        $this->assertFalse($exists);
    }

    /**
     * Test collection helper method
     */
    public function testGetCollection(): void
    {
        $this->Registry->set('twitter', 'foo', TestProvider::class);
        $this->Registry->set('twitter', 'bar', TestProvider::class);
        $collection = $this->Registry->getCollection();

        $this->assertInstanceOf('Cake\Collection\Collection', $collection);
        $this->assertCount(1, $collection);
        $this->assertCount(2, $collection->first());
    }
}
