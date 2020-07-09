<?php
namespace Qobo\Social\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use Qobo\Social\Controller\NetworksController;

/**
 * Qobo\Social\Controller\NetworksController Test Case
 */
class NetworksControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Qobo/Social.Networks',
        'plugin.Qobo/Social.Accounts',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->get('/social/networks/index');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->get('/social/networks/view/00000000-0000-0000-0000-000000000001');
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->get('/social/networks/add');
        $this->assertResponseOk();
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->get('/social/networks/edit/00000000-0000-0000-0000-000000000001');
        $this->assertResponseOk();
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->post('/social/networks/delete/00000000-0000-0000-0000-000000000001');
        $this->assertRedirect('/social/networks');
    }
}
