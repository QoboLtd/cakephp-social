<?php
namespace Qobo\Social\Test\TestCase\Controller;

use Cake\Event\EventList;
use Cake\Event\EventManager;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Qobo\Social\Model\Entity\Account;

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
        $table = TableRegistry::getTableLocator()->get('Qobo/Social.Accounts');
        $this->Accounts = $table;
        $this->eventManager = EventManager::instance()->setEventList(new EventList());
        $this->eventManager->trackEvents(true);
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
