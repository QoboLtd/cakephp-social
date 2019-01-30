<?php
namespace Qobo\Social\Test\App\Provider;

use Cake\ORM\TableRegistry;
use Qobo\Social\Model\Table\PostsTable;
use Qobo\Social\Provider\AbstractResponse;

/**
 * Test Provider
 */
class TestResponse extends AbstractResponse
{
    /**
     * {@inheritDoc}
     */
    public function getPosts(): array
    {
        $config = TableRegistry::getTableLocator()->exists('Posts') ? [] : ['className' => PostsTable::class];
        /** @var \Qobo\Social\Model\Table\PostsTable $table */
        $table = TableRegistry::getTableLocator()->get('Posts', $config);
        /** @var \Qobo\Social\Model\Entity\Post $goodPost */
        $goodPost = $table->newEntity([
            'account_id' => '00000000-0000-0000-0000-000000000001',
            'external_post_id' => null,
            'post_id' => null,
            'type' => 'Lorem ipsum dolor sit amet',
            'url' => 'Lorem ipsum dolor sit amet',
            'subject' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat.',
        ]);

        /** @var \Qobo\Social\Model\Entity\Post $badPost */
        $badPost = $table->newEntity([
            'account_id' => '00000000-0000-0000-0000-000000000001',
            'external_post_id' => null,
            'post_id' => null,
            'type' => '',
            'url' => '',
            'subject' => '',
            'content' => '',
        ]);

        return [$goodPost, $badPost];
    }
}
