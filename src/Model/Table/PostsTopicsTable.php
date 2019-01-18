<?php
namespace Qobo\Social\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PostsTopics Model
 *
 * @property \Qobo\Social\Model\Table\PostsTable|\Cake\ORM\Association\BelongsTo $Posts
 * @property \Qobo\Social\Model\Table\TopicsTable|\Cake\ORM\Association\BelongsTo $Topics
 *
 * @method \Qobo\Social\Model\Entity\PostsTopic get($primaryKey, $options = [])
 * @method \Qobo\Social\Model\Entity\PostsTopic newEntity($data = null, array $options = [])
 * @method \Qobo\Social\Model\Entity\PostsTopic[] newEntities(array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\PostsTopic|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Social\Model\Entity\PostsTopic|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Social\Model\Entity\PostsTopic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\PostsTopic[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\PostsTopic findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PostsTopicsTable extends Table
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

        $this->setTable('posts_topics');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Social.Posts'
        ]);
        $this->belongsTo('Topics', [
            'foreignKey' => 'topic_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Social.Topics'
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
        $rules->add($rules->existsIn(['post_id'], 'Posts'));
        $rules->add($rules->existsIn(['topic_id'], 'Topics'));

        return $rules;
    }
}
