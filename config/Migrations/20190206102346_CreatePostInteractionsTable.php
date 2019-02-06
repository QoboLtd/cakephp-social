<?php
use Migrations\AbstractMigration;

class CreatePostInteractionsTable extends AbstractMigration
{

    public function up()
    {

        $this->table('qobo_social_post_interactions', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('post_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('interaction_type_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('value_int', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('import_date', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'post_id',
                    'interaction_type_id',
                ],
                [
                    'name' => 'post_id_interaction_type_id',
                    'unique' => true,
                ]
            )
            ->create();
    }

    public function down()
    {
        $this->dropTable('qobo_social_post_interactions');
    }
}
