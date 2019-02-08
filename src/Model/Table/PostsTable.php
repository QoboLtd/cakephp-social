<?php
namespace Qobo\Social\Model\Table;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Qobo\Social\Model\Entity\Post;
use Qobo\Social\Publisher\PublisherException;

/**
 * Posts Model
 *
 * @property \Qobo\Social\Model\Table\AccountsTable|\Cake\ORM\Association\BelongsTo $Accounts
 * @property \Qobo\Social\Model\Table\PostsTable|\Cake\ORM\Association\BelongsTo $Posts
 * @property \Qobo\Social\Model\Table\PostsTable|\Cake\ORM\Association\HasMany $Posts
 * @property \Qobo\Social\Model\Table\TopicsTable|\Cake\ORM\Association\BelongsToMany $Topics
 * @property \Qobo\Social\Model\Table\PostInteractionsTable|\Cake\ORM\Association\HasMany $PostInteractions
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

        $this->setTable('qobo_social_posts');
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
        $this->hasMany('LatestPostInteractions', [
            'foreignKey' => 'post_id',
            'className' => 'Qobo/Social.PostInteractions',
            'finder' => [
                'latest' => [
                    'contain' => ['InteractionTypes']
                ]
            ],
        ]);
        $this->hasMany('PostInteractions', [
            'foreignKey' => 'post_id',
            'dependent' => true,
            'className' => 'Qobo/Social.PostInteractions',
            'finder' => [
                'all' => [
                    'order' => ['import_date' => 'DESC'],
                    'contain' => ['InteractionTypes']
                ]
            ],
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
            ->scalar('external_post_id')
            ->maxLength('external_post_id', 255)
            ->allowEmpty('external_post_id');

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

    /**
     * Account validation rules for posting to a social network.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationPublish(Validator $validator): Validator
    {
        $validator = $this->validationDefault($validator);

        $validator->add('account_id', 'can-post', [
            'rule' => 'canAccountPost',
            'message' => __('Only accounts marked as ours can post to social networks.'),
            'provider' => 'table',
        ]);

        return $validator;
    }

    /**
     * Validation rule which checks whether the account is marked as ours.
     *
     * @param string $accountId Account ID.
     * @param mixed[] $context Validation context.
     * @return bool True if account can post.
     */
    public function canAccountPost(string $accountId, array $context): bool
    {
        $account = $this->Accounts->find()->where([
            'id' => $accountId,
            'is_ours' => true,
        ]);

        return (bool)$account->count();
    }

    /**
     * After save event.
     *
     * @param \Cake\Event\Event $event [description]
     * @param \Qobo\Social\Model\Entity\Post $entity [description]
     * @param \ArrayObject $options [description]
     * @return void
     */
    public function afterSave(Event $event, Post $entity, ArrayObject $options): void
    {
        // If entity is not new or has the external id already set we should exit.
        $externalId = $entity->get('external_post_id');
        $enabled = Configure::read('Qobo/Social.publishEnabled', false);
        if ($enabled === true && $entity->isNew() && empty($externalId)) {
            $this->runPublisher($entity);
        }
    }

    /**
     * Run a social publisher based on account and network.
     *
     * @param \Qobo\Social\Model\Entity\Post $entity Post entity.
     * @return void
     */
    protected function runPublisher(Post $entity): void
    {
        /** @var \Qobo\Social\Model\Table\AccountsTable $accounts */
        $accounts = $this->Accounts;
        /** @var \Qobo\Social\Model\Entity\Account $account */
        $account = $accounts->get($entity->get('account_id'), [
            'finder' => 'decrypt',
        ]);
        // If the associated account is not found or is not ours we should exit.
        if ($account->get('is_ours') === false) {
            return;
        }

        /** @var \Qobo\Social\Model\Table\NetworksTable $networks */
        $networks = TableRegistry::getTableLocator()->get('Qobo/Social.Networks');
        /** @var \Qobo\Social\Model\Entity\Network $network */
        $network = $networks->get($account->get('network_id'), [
            'finder' => 'decrypt',
        ]);

        // Find the publisher and exit if not found.
        $class = Configure::read(sprintf('Qobo/Social.publisher.%s', $network->get('name')));
        if (empty($class) || !class_exists($class)) {
            return;
        }

        // Run the publisher and update the entity.
        /** @var \Qobo\Social\Publisher\PublisherInterface $publisher */
        $publisher = new $class();
        $publisher->setAccount($account);
        $publisher->setNetwork($network);
        /** @var \Qobo\Social\Publisher\PublisherResponseInterface $response */
        try {
            $response = $publisher->publish($entity);
            $entity = $this->patchEntity($entity, ['external_post_id' => $response->getExternalPostId()], ['validate' => false]);
            $this->save($entity);
        } catch (PublisherException $e) {
            // @ignoreException
        }
    }
}
