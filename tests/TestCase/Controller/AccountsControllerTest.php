<?php
namespace Qobo\Social\Test\TestCase\Controller;

use Cake\Event\EventList;
use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Qobo\Social\Event\EventName;
use Qobo\Social\Model\Entity\Account;
use Qobo\Social\Model\Table\AccountsTable;
use stdClass;

/**
 * Qobo\Social\Controller\AccountsController Test Case
 */
class AccountsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/social.accounts',
        'plugin.qobo/social.networks',
        'plugin.qobo/social.posts',
    ];

    /**
     * Event manager.
     *
     * @var \Cake\Event\EventManager;
     */
    protected $eventManager;

    /**
     * Accounts table
     *
     * @var \Qobo\Social\Model\Table\AccountsTable
     */
    protected $Accounts;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        /** @var \Qobo\Social\Model\Table\AccountsTable $table */
        $table = TableRegistry::getTableLocator()->get('Qobo/Social.Accounts', ['className' => AccountsTable::class]);
        $this->Accounts = $table;
        $this->eventManager = EventManager::instance()->setEventList(new EventList());
        $this->eventManager->trackEvents(true);

        $this->eventManager->off((string)EventName::QOBO_SOCIAL_CONNECT_TWITTER());
    }

    /**
     * {@inheritDoc}
     */
    public function tearDown(): void
    {
        unset($this->eventManager);
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->get('/social/accounts/index');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->get('/social/accounts/view/00000000-0000-0000-0000-000000000001');
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->get('/social/accounts/add');
        $this->assertResponseOk();
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->get('/social/accounts/edit/00000000-0000-0000-0000-000000000001');
        $this->assertResponseOk();
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->post('/social/accounts/delete/00000000-0000-0000-0000-000000000001');
        $this->assertRedirect('/social/accounts');
    }

    /**
     * Test connect method when no event listeners are defined for the given type
     *
     * @return void
     */
    public function testConnectNoDefinedEventListeners(): void
    {
        $this->get('/social/accounts/connect/twitter');
        $this->assertResponseError();
    }

    /**
     * Test connect method when no event listeners are defined for the given type
     *
     * @return void
     */
    public function testConnectProviderEventFired(): void
    {
        $this->eventManager->on((string)EventName::QOBO_SOCIAL_CONNECT_TWITTER(), function ($event) {
            return false; // stop event propagation
        });

        $this->get('/social/accounts/connect/twitter');
        $this->assertEventFired((string)EventName::QOBO_SOCIAL_CONNECT_TWITTER());
    }

    /**
     * Test connect method when no event listeners are defined for the given type
     *
     * @return void
     */
    public function testConnectResponseReturned(): void
    {
        $location = 'https://google.com';
        $response = new Response();
        $response = $response->withLocation($location);

        $this->eventManager->on((string)EventName::QOBO_SOCIAL_CONNECT_TWITTER(), function ($event) use ($response) {
            return $response;
        });

        $this->get('/social/accounts/connect/twitter');
        $this->assertEventFired((string)EventName::QOBO_SOCIAL_CONNECT_TWITTER());
        $this->assertRedirect($location);
    }

    /**
     * Test connect method when enclosed event doesn't return an Account entity.
     *
     * @return void
     */
    public function testConnectEventReturnsInvalidClass(): void
    {
        $this->eventManager->on((string)EventName::QOBO_SOCIAL_CONNECT_TWITTER(), function ($event) {
            return new stdClass();
        });

        $this->get('/social/accounts/connect/twitter');
        $this->assertEventFired((string)EventName::QOBO_SOCIAL_CONNECT_TWITTER());
        $this->assertResponseFailure();
        $this->assertResponseContains('Event must return an instance of Account');
    }

    /**
     * Test connect method
     *
     * @return void
     */
    public function testConnectSuccessful(): void
    {
        $entity = $this->getAccountEntity();
        $this->eventManager->on((string)EventName::QOBO_SOCIAL_CONNECT_TWITTER(), function ($event) use ($entity) {
            return $entity;
        });

        $this->enableRetainFlashMessages();
        $this->get('/social/accounts/connect/twitter');
        $this->assertEventFired((string)EventName::QOBO_SOCIAL_CONNECT_TWITTER());

        $id = $entity->get('id');
        $this->assertNotEmpty($id);
        $this->assertRedirect('/social/accounts/view/' . $id);
    }

    /**
     * Helper function to generate an account entity.
     *
     * @return \Qobo\Social\Model\Entity\Account Account entity.
     */
    protected function getAccountEntity(): Account
    {
        return $this->Accounts->newEntity([
            'handle' => 'foobar',
            'network_id' => '00000000-0000-0000-0000-000000000001',
        ]);
    }
}
