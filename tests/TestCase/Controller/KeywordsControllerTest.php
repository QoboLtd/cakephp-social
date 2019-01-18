<?php
namespace Qobo\Social\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use Qobo\Social\Controller\KeywordsController;

/**
 * Qobo\Social\Controller\KeywordsController Test Case
 */
class KeywordsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/social.keywords',
        'plugin.qobo/social.topics',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->get('/social/keywords/index');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->get('/social/keywords/view/32591665-5810-4257-bc3c-e9c987dc784a');
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->get('/social/keywords/add');
        $this->assertResponseOk();
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->get('/social/keywords/edit/32591665-5810-4257-bc3c-e9c987dc784a');
        $this->assertResponseOk();
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->post('/social/keywords/delete/32591665-5810-4257-bc3c-e9c987dc784a');
        $this->assertRedirect('/social/keywords');
    }
}
