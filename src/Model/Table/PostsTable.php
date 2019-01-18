<?php
namespace Qobo\Social\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Posts Model
 *
 * @property \Qobo\Social\Model\Table\AccountsTable|\Cake\ORM\Association\BelongsTo $Accounts
 * @property \Qobo\Social\Model\Table\PostsTable|\Cake\ORM\Association\BelongsTo $Posts
 * @property \Qobo\Social\Model\Table\PostsTable|\Cake\ORM\Association\HasMany $Posts
 * @property \Qobo\Social\Model\Table\TopicsTable|\Cake\ORM\Association\BelongsToMany $Topics
 *
 * @method \Qobo\Social\Model\Entity\Post get($primaryKey, $options = [])
 * @method \Qobo\Social\Model\Entity\Post newEntity($data = null, array $options = [])
 * @method \Qobo\Social\Model\Entity\Post[] newEntities(array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\Post|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Social\Model\Entity\Post|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Social\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\Post[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\Post findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PostsTable extends Table
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

        $this->setTable('posts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Social.Accounts'
        ]);
        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
            'className' => 'Qobo/Social.Posts'
        ]);
        $this->hasMany('Posts', [
            'foreignKey' => 'post_id',
            'className' => 'Qobo/Social.Posts'
        ]);
        $this->belongsToMany('Topics', [
            'foreignKey' => 'post_id',
            'targetForeignKey' => 'topic_id',
            'through' => 'Qobo/Social.PostsTopics',
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
            ->scalar('type')
            ->maxLength('type', 255)
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->notEmpty('url');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 255)
            ->requirePresence('subject', 'create')
            ->notEmpty('subject');

        $validator
            ->scalar('content')
            ->maxLength('content', 4294967295)
            ->allowEmpty('content');

        $validator
            ->dateTime('publish_date')
            ->allowEmpty('publish_date');

        $validator
            ->scalar('extra')
            ->maxLength('extra', 4294967295)
            ->allowEmpty('extra');

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
        $rules->add($rules->existsIn(['account_id'], 'Accounts'));
        $rules->add($rules->existsIn(['post_id'], 'Posts'));

        return $rules;
    }
}
