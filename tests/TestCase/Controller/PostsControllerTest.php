<?php
namespace Qobo\Social\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use Qobo\Social\Controller\PostsController;

/**
 * Qobo\Social\Controller\PostsController Test Case
 */
class PostsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/social.accounts',
        'plugin.qobo/social.posts',
        'plugin.qobo/social.posts_topics',
        'plugin.qobo/social.topics',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->get('/social/posts/index');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->get('/social/posts/view/00000000-0000-0000-0000-000000000001');
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->get('/social/posts/add');
        $this->assertResponseOk();
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->get('/social/posts/edit/00000000-0000-0000-0000-000000000001');
        $this->assertResponseOk();
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->post('/social/posts/delete/00000000-0000-0000-0000-000000000001');
        $this->assertRedirect('/social/posts');
    }
}
