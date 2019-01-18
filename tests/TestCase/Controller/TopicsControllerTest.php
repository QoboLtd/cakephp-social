<?php
namespace Qobo\Social\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use Qobo\Social\Controller\TopicsController;

/**
 * Qobo\Social\Controller\TopicsController Test Case
 */
class TopicsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/social.topics',
        'plugin.qobo/social.keywords',
        'plugin.qobo/social.posts',
        'plugin.qobo/social.posts_topics',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->get('/social/topics/index');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->get('/social/topics/view/7aa61c8b-c28a-463d-bb69-df35ab268960');
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->get('/social/topics/add');
        $this->assertResponseOk();
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->get('/social/topics/edit/7aa61c8b-c28a-463d-bb69-df35ab268960');
        $this->assertResponseOk();
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->post('/social/topics/delete/7aa61c8b-c28a-463d-bb69-df35ab268960');
        $this->assertRedirect('/social/topics');
    }
}
