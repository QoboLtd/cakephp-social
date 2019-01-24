<?php
namespace Qobo\Social\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Qobo\Social\Model\Entity\Network;

/**
 * Networks Model
 *
 * @property \Qobo\Social\Model\Table\AccountsTable|\Cake\ORM\Association\HasMany $Accounts
 *
 * @method \Qobo\Social\Model\Entity\Network get($primaryKey, $options = [])
 * @method \Qobo\Social\Model\Entity\Network newEntity($data = null, array $options = [])
 * @method \Qobo\Social\Model\Entity\Network[] newEntities(array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\Network|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Social\Model\Entity\Network|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Social\Model\Entity\Network patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\Network[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\Network findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Qobo\Utils\Model\Behavior\EncryptedFieldsBehavior
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NetworksTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('qobo_social_networks');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Qobo/Utils.EncryptedFields', [
            'enabled' => true,
            'encryptionKey' => Configure::readOrFail('Qobo/Social.encrypt.key'),
            'fields' => [
                'oauth_consumer_key',
                'oauth_consumer_secret',
            ],
        ]);

        $this->hasMany('Accounts', [
            'foreignKey' => 'network_id',
            'className' => 'Qobo/Social.Accounts'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->notEmpty('url');

        $validator
            ->boolean('active')
            ->allowEmpty('active');

        $validator
            ->dateTime('trashed')
            ->allowEmpty('trashed');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }
}
