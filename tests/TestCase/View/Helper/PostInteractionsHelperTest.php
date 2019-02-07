<?php
namespace Qobo\Social\Test\TestCase\View\Helper;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\View\View;
use Qobo\Social\View\Helper\PostInteractionsHelper;

/**
 * Qobo\Social\View\Helper\PostInteractionsHelper Test Case
 */
class PostInteractionsHelperTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/social.interaction_types',
        'plugin.qobo/social.post_interactions',
        'plugin.qobo/social.posts',
    ];

    /**
     * Test subject
     *
     * @var \Qobo\Social\View\Helper\PostInteractionsHelper
     */
    public $PostInteractions;

    /**
     * Test subject
     *
     * @var \Cake\View\View
     */
    public $View;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->View = new View();
        $this->PostInteractions = new PostInteractionsHelper($this->View);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PostInteractions);
        unset($this->View);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization(): void
    {
        $element = $this->PostInteractions->getConfig('element');
        $this->assertTrue($this->View->elementExists($element));
    }

    /**
     * Test render
     *
     * @return void
     */
    public function testRender(): void
    {
        $table = TableRegistry::getTableLocator()->get('Qobo/Social.Posts');
        $post = $table->get('00000000-0000-0000-0000-000000000001', [
            'contain' => ['LatestPostInteractions']
        ]);
        /** @var \Qobo\Social\Model\Entity\PostInteraction[] $interactions */
        $interactions = $post->get('latest_post_interactions');
        $output = $this->PostInteractions->render($interactions);
        $this->assertContains('Retweets', $output);
        $this->assertContains('>5</', $output);
        $this->assertContains('Favorites', $output);
        $this->assertContains('>10</', $output);
    }

    /**
     * Test render
     *
     * @return void
     */
    public function testRenderSingle(): void
    {
        $table = TableRegistry::getTableLocator()->get('Qobo/Social.Posts');
        $post = $table->get('00000000-0000-0000-0000-000000000001', [
            'contain' => ['LatestPostInteractions']
        ]);
        /** @var \Qobo\Social\Model\Entity\PostInteraction $interaction */
        $interaction = $post->get('latest_post_interactions')[0];
        $output = $this->PostInteractions->render($interaction);
        $this->assertNotEmpty($output);
    }

    /**
     * Test render
     *
     * @return void
     */
    public function testRenderInteractionTypesMissing(): void
    {
        $table = TableRegistry::getTableLocator()->get('Qobo/Social.PostInteractions');
        /** @var \Qobo\Social\Model\Entity\PostInteraction $interaction */
        $interaction = $table->get('00000000-0000-0000-0000-000000000001');
        $output = $this->PostInteractions->render($interaction);
        $this->assertEmpty($output);
    }
}
