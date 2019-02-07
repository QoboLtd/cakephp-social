<?php
use Migrations\AbstractMigration;

class CreateIteractionTypesTable extends AbstractMigration
{

    public function up()
    {

        $this->table('qobo_social_interaction_types', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('network_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('value_type', 'string', [
                'default' => 'int',
                'limit' => 25,
                'null' => false,
            ])
            ->addColumn('label', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addIndex(
                [
                    'network_id',
                    'slug',
                ],
                [
                    'name' => 'network_id_slug',
                    'unique' => true,
                ]
            )
            ->create();
    }

    public function down()
    {
        $this->dropTable('qobo_social_interaction_types');
    }
}
