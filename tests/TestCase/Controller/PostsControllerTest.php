<?php
namespace Qobo\Social\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

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
        'plugin.qobo/social.interaction_types',
        'plugin.qobo/social.post_interactions',
        'plugin.qobo/social.posts',
        'plugin.qobo/social.posts_topics',
        'plugin.qobo/social.topics',
    ];

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        Configure::delete('Qobo/Social.publisher');

        parent::setUp();
    }

    /**
     * {@inheritDoc}
     */
    public function tearDown(): void
    {
        TableRegistry::getTableLocator()->clear();

        parent::tearDown();
    }

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
     * Test add method post
     *
     * @dataProvider addEditProvider
     * @param mixed[] $data Post data
     * @param bool $returnValue Return value
     * @param string $flashMessage Flash Message
     * @return void
     */
    public function testAddPost(array $data, bool $returnValue, string $flashMessage): void
    {
        /** @var \Qobo\Social\Model\Table\PostsTable&\PHPUnit\Framework\MockObject\MockObject */
        $table = $this->getMockForModel('Qobo/Social.Posts', ['save']);
        $table->expects($this->once())
            ->method('save')
            ->will($this->returnValue($returnValue));
        TableRegistry::getTableLocator()->set('Posts', $table);

        $this->enableRetainFlashMessages();
        $this->post('/social/posts/add', $data);
        $this->assertSession($flashMessage, 'Flash.flash.0.message');
        if ($returnValue === true) {
            $this->assertRedirect('/social/posts');
        }
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
     * Test edit method post
     *
     * @dataProvider addEditProvider
     * @param mixed[] $data Post data
     * @param bool $returnValue Return value
     * @param string $flashMessage Flash Message
     * @return void
     */
    public function testEditPost(array $data, bool $returnValue, string $flashMessage): void
    {
        /** @var \Qobo\Social\Model\Table\PostsTable&\PHPUnit\Framework\MockObject\MockObject */
        $table = $this->getMockForModel('Qobo/Social.Posts', ['save']);
        $table->expects($this->once())
            ->method('save')
            ->will($this->returnValue($returnValue));
        TableRegistry::getTableLocator()->set('Posts', $table);

        $this->enableRetainFlashMessages();
        $this->post('/social/posts/edit/00000000-0000-0000-0000-000000000001', $data);
        $this->assertSession($flashMessage, 'Flash.flash.0.message');
        if ($returnValue === true) {
            $this->assertRedirect('/social/posts');
        }
    }

    /**
     * Data provider for add/edit methods.
     *
     * @return mixed[]
     */
    public function addEditProvider(): array
    {
        $data = [
            'account_id' => '00000000-0000-0000-0000-000000000001',
            'type' => 'foobar',
            'url' => 'https://google.com',
            'subject' => 'About Foo',
            'content' => 'Foo is bar',
        ];

        return [
            [
                $data,
                true,
                'The post has been saved.',
            ],
            [
                $data,
                false,
                'The post could not be saved. Please, try again.',
            ]
        ];
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

    /**
     * Test delete method with error
     *
     * @return void
     */
    public function testDeleteError(): void
    {
        /** @var \Qobo\Social\Model\Table\PostsTable&\PHPUnit\Framework\MockObject\MockObject */
        $table = $this->getMockForModel('Qobo/Social.Posts', ['delete']);
        $table->expects($this->once())
            ->method('delete')
            ->will($this->returnValue(false));
        TableRegistry::getTableLocator()->set('Posts', $table);

        $this->enableRetainFlashMessages();
        $this->post('/social/posts/delete/00000000-0000-0000-0000-000000000001');
        $this->assertSession('The post could not be deleted. Please, try again.', 'Flash.flash.0.message');
        $this->assertRedirect('/social/posts');
    }
}
