<?php
namespace Qobo\Social\Test\TestCase\Provider\Twitter;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use InvalidArgumentException;
use Qobo\Social\Model\Table\NetworksTable;
use Qobo\Social\Provider\ProviderRegistry;
use Qobo\Social\Test\App\Provider\Twitter\TwitterPremiumSearchProvider;

/**
 * Qobo\Social\Provider\Twitter\TwitterPremiumSearchProvider Test Case
 */
class TwitterPremiumSearchProviderTest extends TestCase
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
        $this->Registry->set('twitter', '30day-dev', [
            'className' => TwitterPremiumSearchProvider::class,
            'config' => [
                'env' => 'dev',
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
        /** @var \Qobo\Social\Model\Entity\Network $network */
        $network = $this->Networks->find('all')->where(['name' => 'twitter'])->first();
        $provider = $network->getSocialProvider('30day-dev');
        $results = $provider->read();
        $this->assertTrue($results);
    }
}
