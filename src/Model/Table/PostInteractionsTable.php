<?php
namespace Qobo\Social\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PostInteractions Model
 *
 * @property \Qobo\Social\Model\Table\PostsTable|\Cake\ORM\Association\BelongsTo $Posts
 * @property \Qobo\Social\Model\Table\InteractionTypesTable|\Cake\ORM\Association\BelongsTo $InteractionTypes
 *
 * @method \Qobo\Social\Model\Entity\PostInteraction get($primaryKey, $options = [])
 * @method \Qobo\Social\Model\Entity\PostInteraction newEntity($data = null, array $options = [])
 * @method \Qobo\Social\Model\Entity\PostInteraction[] newEntities(array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\PostInteraction|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Social\Model\Entity\PostInteraction|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Social\Model\Entity\PostInteraction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\PostInteraction[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\PostInteraction findOrCreate($search, callable $callback = null, $options = [])
 */
class PostInteractionsTable extends Table
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

        $this->setTable('qobo_social_post_interactions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Social.Posts'
        ]);
        $this->belongsTo('InteractionTypes', [
            'foreignKey' => 'interaction_type_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Social.InteractionTypes'
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
            ->integer('value_int')
            ->requirePresence('value_int', 'create')
            ->notEmpty('value_int');

        $validator
            ->dateTime('import_date')
            ->requirePresence('import_date', 'create')
            ->notEmpty('import_date');

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
        $rules->add($rules->existsIn(['post_id'], 'Posts'));
        $rules->add($rules->existsIn(['interaction_type_id'], 'InteractionTypes'));
        $rules->add($rules->isUnique(
            ['post_id', 'import_date', 'interaction_type_id'],
            __d('Qobo/Social', 'This post, import date and interaction type combination has already been used.')
        ));

        return $rules;
    }

    /**
     * Find the most recent post interaction(s).
     *
     * @param \Cake\ORM\Query $query Query object.
     * @param mixed[] $params Optional params.
     * @return \Cake\ORM\Query Query object.
     */
    public function findLatest(Query $query, array $params = []): Query
    {
        $subQuery = $this->query()
            ->select([
                $this->aliasField('post_id'),
                $this->aliasField('interaction_type_id'),
                'max_import_date' => $query->func()->max('import_date')
            ])
            ->group([$this->aliasField('post_id'), $this->aliasField('interaction_type_id')]);

        $whereFields = ['post_id', 'interaction_type_id', 'import_date'];
        $whereClause = implode(', ', $whereFields);
        $query->where(['(' . $whereClause . ') IN' => $subQuery]);

        return $query;
    }
}
