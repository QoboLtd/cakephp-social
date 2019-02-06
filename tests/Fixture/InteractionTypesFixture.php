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
                'id' => '208a162e-38dc-4843-bf20-ac14838ef972',
                'network_id' => 'fcf220b3-7152-454d-bb09-7d18926ba103',
                'slug' => 'Lorem ipsum dolor sit amet',
                'value_type' => 'Lorem ipsum dolor sit a',
                'label' => 'Lorem ipsum dolor sit amet'
            ],
        ];
        parent::init();
    }
}
