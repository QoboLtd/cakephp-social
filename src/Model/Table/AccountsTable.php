<?php
namespace Qobo\Social\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Qobo\Social\Model\Entity\Account;

/**
 * Accounts Model
 *
 * @property \Qobo\Social\Model\Table\NetworksTable|\Cake\ORM\Association\BelongsTo $Networks
 * @property \Qobo\Social\Model\Table\PostsTable|\Cake\ORM\Association\HasMany $Posts
 *
 * @method \Qobo\Social\Model\Entity\Account get($primaryKey, $options = [])
 * @method \Qobo\Social\Model\Entity\Account newEntity($data = null, array $options = [])
 * @method \Qobo\Social\Model\Entity\Account[] newEntities(array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\Account|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Social\Model\Entity\Account|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Social\Model\Entity\Account patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\Account[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\Account findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Qobo\Utils\Model\Behavior\EncryptedFieldsBehavior
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccountsTable extends Table
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

        $this->setTable('qobo_social_accounts');
        $this->setDisplayField('handle');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Qobo/Utils.EncryptedFields', [
            'enabled' => function (Account $entity) {
                $enabled = Configure::read('Qobo/Social.encrypt.enabled', true);

                return ($enabled === false) ? $enabled : $entity->is_ours;
            },
            'encryptionKey' => Configure::readOrFail('Qobo/Social.encrypt.key'),
            'fields' => [
                'credentials',
            ],
        ]);

        $this->belongsTo('Networks', [
            'foreignKey' => 'network_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Social.Networks',
        ]);
        $this->hasMany('Posts', [
            'foreignKey' => 'account_id',
            'className' => 'Qobo/Social.Posts',
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
            ->uuid('network_id')
            ->notEmpty('network_id');

        $validator
            ->scalar('handle')
            ->maxLength('handle', 255)
            ->notEmpty('handle');

        $validator
            ->boolean('active')
            ->allowEmpty('active');

        $validator
            ->boolean('is_ours')
            ->allowEmpty('is_ours');

        $validator
            ->scalar('credentials')
            ->maxLength('credentials', 4294967295)
            ->allowEmpty('credentials');

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
        $rules->add($rules->existsIn(['network_id'], 'Networks'));

        return $rules;
    }

    /**
     * Custom finder method which returns accounts marked as `ours`.
     *
     * @param \Cake\ORM\Query $query Query object.
     * @param mixed[] $options Options
     * @return \Cake\ORM\Query Query object.
     */
    public function findOurs(Query $query, array $options = []): Query
    {
        return $query->find('all', $options)->where(['is_ours' => true]);
    }
}
