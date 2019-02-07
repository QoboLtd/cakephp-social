<?php
namespace Qobo\Social\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Qobo\Social\View\Helper\PostInteractionsHelper;

/**
 * Qobo\Social\View\Helper\PostInteractionsHelper Test Case
 */
class PostInteractionsHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Social\View\Helper\PostInteractionsHelper
     */
    public $PostInteractions;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->PostInteractions = new PostInteractionsHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PostInteractions);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
