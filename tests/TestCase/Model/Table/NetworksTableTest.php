<?php
namespace Qobo\Social\Test\TestCase\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
use InvalidArgumentException;
use Qobo\Social\Model\Table\NetworksTable;
use Qobo\Social\Provider\ProviderInterface;
use Qobo\Social\Provider\ProviderRegistry;
use Qobo\Social\Test\App\Provider\TestProvider;

/**
 * Qobo\Social\Model\Table\NetworksTable Test Case
 */
class NetworksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Social\Model\Table\NetworksTable
     */
    public $Networks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/social.networks',
        'plugin.qobo/social.accounts'
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
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Networks);

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
        $result = $this->Networks->validationDefault($validator);
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
        $result = $this->Networks->buildRules($rules);
        $this->assertInstanceOf(RulesChecker::class, $result);
    }

    /**
     * Test social provider getter of Network entity.
     *
     * @return void
     */
    public function testEntityGetSocialProvider(): void
    {
        ProviderRegistry::resetInstance();

        // Add test provider to the registry.
        $registry = ProviderRegistry::getInstance();
        $registry->set('twitter', 'test', TestProvider::class);

        /** @var \Qobo\Social\Model\Entity\Network $network */
        $network = $this->Networks->find('all')->where(['name' => 'twitter'])->first();
        $this->assertNotNull($network);
        /** @var \Qobo\Social\Test\App\Provider\TestProvider $provider */
        $provider = $network->getSocialProvider('test');
        $this->assertInstanceOf(ProviderInterface::class, $provider);
        $this->assertEquals($network->oauth_consumer_key, $provider->getConsumerKey());
        $this->assertEquals($network->oauth_consumer_secret, $provider->getConsumerSecret());
    }

    /**
     * Test social provider getter of Network entity.
     *
     * @return void
     */
    public function testEntityGetInvalidSocialProvider(): void
    {
        ProviderRegistry::resetInstance();

        $this->expectException(InvalidArgumentException::class);

        /** @var \Qobo\Social\Model\Entity\Network $network */
        $network = $this->Networks->find('all')->where(['name' => 'twitter'])->first();
        $this->assertNotNull($network);

        try {
            $network->getSocialProvider('test');
        } catch (InvalidArgumentException $e) {
            $this->assertContains('not a valid social provider', $e->getMessage());

            throw $e;
        }
    }
}
