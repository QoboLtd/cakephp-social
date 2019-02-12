<?php
use Cake\Utility\Text;
use Migrations\AbstractMigration;

class AddTwitterNetworkData extends AbstractMigration
{

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $row = $this->findTwitterNetwork();
        if (empty($row)) {
            $networkId = Text::uuid();
            $networkData = [
                'id' => $networkId,
                'name' => 'twitter',
                'title' => 'Twitter',
                'url' => 'https://twitter.com',
                'active' => false,
            ];

            $networksTable = $this->table('qobo_social_networks');
            $networksTable->insert($networkData)->save();

            $typesData = [
                [
                    'id' => Text::uuid(),
                    'network_id' => $networkId,
                    'slug' => 'retweet_count',
                    'value_type' => 'int',
                    'label' => 'Retweets',
                ],
                [
                    'id' => Text::uuid(),
                    'network_id' => $networkId,
                    'slug' => 'favorite_count',
                    'value_type' => 'int',
                    'label' => 'Favorites',
                ],
            ];

            $typesTable = $this->table('qobo_social_interaction_types');
            foreach ($typesData as $typeData) {
                $typesTable->insert($typeData)->save();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $row = $this->findTwitterNetwork();
        if (!empty($row['id'])) {
            $networkId = $row['id'];
            $count = $this->execute('DELETE FROM qobo_social_networks');
            $count = $this->execute("DELETE FROM qobo_social_interaction_types WHERE `network_id` = '{$networkId}' ");
        }
    }

    /**
     * Find twitter network.
     *
     * @return array|bool Array of fields or false if not found.
     */
    protected function findTwitterNetwork()
    {
        $network = 'twitter';

        return $this->fetchRow("SELECT * FROM qobo_social_networks WHERE `name` = '{$network}'");
    }
}
