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
        $this->get('/social/posts/view/17dcb0b0-46aa-4ec8-91a1-74ec48b1d5e6');
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->get('/social/posts/add/17dcb0b0-46aa-4ec8-91a1-74ec48b1d5e6');
        $this->assertResponseOk();
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->get('/social/posts/edit/17dcb0b0-46aa-4ec8-91a1-74ec48b1d5e6');
        $this->assertResponseOk();
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->post('/social/posts/delete/17dcb0b0-46aa-4ec8-91a1-74ec48b1d5e6');
        $this->assertRedirect('/social/posts');
    }
}
