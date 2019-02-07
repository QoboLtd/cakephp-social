<?php
namespace Qobo\Social\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InteractionTypes Model
 *
 * @property \Qobo\Social\Model\Table\NetworksTable|\Cake\ORM\Association\BelongsTo $Networks
 *
 * @method \Qobo\Social\Model\Entity\InteractionType get($primaryKey, $options = [])
 * @method \Qobo\Social\Model\Entity\InteractionType newEntity($data = null, array $options = [])
 * @method \Qobo\Social\Model\Entity\InteractionType[] newEntities(array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\InteractionType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Social\Model\Entity\InteractionType|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Social\Model\Entity\InteractionType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\InteractionType[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\InteractionType findOrCreate($search, callable $callback = null, $options = [])
 */
class InteractionTypesTable extends Table
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

        $this->setTable('qobo_social_interaction_types');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Networks', [
            'foreignKey' => 'network_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Social.Networks'
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
            ->scalar('slug')
            ->maxLength('slug', 100)
            ->requirePresence('slug', 'create')
            ->notEmpty('slug');

        $validator
            ->scalar('value_type')
            ->maxLength('value_type', 25)
            ->requirePresence('value_type', 'create')
            ->notEmpty('value_type');

        $validator
            ->scalar('label')
            ->maxLength('label', 100)
            ->allowEmpty('label');

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
        $rules->add($rules->isUnique(
            ['network_id', 'slug'],
            __('This network and slug combination has already been used.')
        ));

        return $rules;
    }
}
