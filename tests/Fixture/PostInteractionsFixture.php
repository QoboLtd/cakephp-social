<?php
namespace Qobo\Social\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PostInteractionsFixture
 *
 */
class PostInteractionsFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'qobo_social_post_interactions';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'post_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'interaction_type_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'value_int' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'import_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'post_id_interaction_type_id' => ['type' => 'unique', 'columns' => ['post_id', 'interaction_type_id'], 'length' => []],
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
                'post_id' => '00000000-0000-0000-0000-000000000001',
                'interaction_type_id' => '00000000-0000-0000-0000-000000000001',
                'value_int' => 5,
                'import_date' => '2019-02-06 10:29:42'
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000002',
                'post_id' => '00000000-0000-0000-0000-000000000001',
                'interaction_type_id' => '00000000-0000-0000-0000-000000000002',
                'value_int' => 10,
                'import_date' => '2019-02-06 10:29:42'
            ],
        ];
        parent::init();
    }
}
