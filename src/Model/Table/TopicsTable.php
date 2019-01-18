<?php
namespace Qobo\Social\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Topics Model
 *
 * @property \Qobo\Social\Model\Table\KeywordsTable|\Cake\ORM\Association\HasMany $Keywords
 * @property \Qobo\Social\Model\Table\PostsTable|\Cake\ORM\Association\BelongsToMany $Posts
 *
 * @method \Qobo\Social\Model\Entity\Topic get($primaryKey, $options = [])
 * @method \Qobo\Social\Model\Entity\Topic newEntity($data = null, array $options = [])
 * @method \Qobo\Social\Model\Entity\Topic[] newEntities(array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\Topic|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Social\Model\Entity\Topic|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Social\Model\Entity\Topic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\Topic[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Social\Model\Entity\Topic findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TopicsTable extends Table
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

        $this->setTable('topics');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Keywords', [
            'foreignKey' => 'topic_id',
            'className' => 'Qobo/Social.Keywords'
        ]);
        $this->belongsToMany('Posts', [
            'foreignKey' => 'topic_id',
            'targetForeignKey' => 'post_id',
            'joinTable' => 'posts_topics',
            'className' => 'Qobo/Social.Posts'
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 4294967295)
            ->allowEmpty('description');

        $validator
            ->boolean('active')
            ->allowEmpty('active');

        $validator
            ->dateTime('trashed')
            ->allowEmpty('trashed');

        return $validator;
    }
}
