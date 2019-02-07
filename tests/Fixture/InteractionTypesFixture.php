<?php
namespace Qobo\Social\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InteractionTypesFixture
 *
 */
class InteractionTypesFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'qobo_social_interaction_types';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'network_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'slug' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'value_type' => ['type' => 'string', 'length' => 25, 'null' => false, 'default' => 'int', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'label' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'network_id_slug' => ['type' => 'unique', 'columns' => ['network_id', 'slug'], 'length' => []],
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
                'network_id' => '00000000-0000-0000-0000-000000000001',
                'slug' => 'retweet_count',
                'value_type' => 'int',
                'label' => 'Retweets'
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000002',
                'network_id' => '00000000-0000-0000-0000-000000000001',
                'slug' => 'favorite_count',
                'value_type' => 'int',
                'label' => 'Favorites'
            ],
        ];
        parent::init();
    }
}
