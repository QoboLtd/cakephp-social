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
                'id' => 'e0aec133-75de-4e3b-9d84-6ba5da822983',
                'post_id' => '82c6dd7e-ee7c-4651-9456-2ab4511da45a',
                'interaction_type_id' => 'dee7c92e-5508-41d6-beea-cf554864d6f2',
                'value_int' => 1,
                'import_date' => '2019-02-06 10:29:42'
            ],
        ];
        parent::init();
    }
}
