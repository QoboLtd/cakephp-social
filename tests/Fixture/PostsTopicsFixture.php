<?php
namespace Qobo\Social\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PostsTopicsFixture
 *
 */
class PostsTopicsFixture extends TestFixture
{
    /**
     * {@inheritDoc}
     */
    public $table = 'qobo_social_posts_topics';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'post_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'topic_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'trashed' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'posts_topics_lookup_post_id' => ['type' => 'index', 'columns' => ['post_id'], 'length' => []],
            'posts_topics_lookup_topic_id' => ['type' => 'index', 'columns' => ['topic_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => '00000000-0000-0000-0000-000000000001',
                'created' => '2019-01-17 12:39:15',
                'modified' => '2019-01-17 12:39:15',
                'post_id' => '17dcb0b0-46aa-4ec8-91a1-74ec48b1d5e6',
                'topic_id' => '7aa61c8b-c28a-463d-bb69-df35ab268960',
                'trashed' => null
            ],
        ];
        parent::init();
    }
}
