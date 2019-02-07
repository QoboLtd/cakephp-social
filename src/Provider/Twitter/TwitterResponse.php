<?php
namespace Qobo\Social\Provider\Twitter;

use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Qobo\Social\Model\Entity\Account;
use Qobo\Social\Model\Entity\Post;
use Qobo\Social\Provider\AbstractResponse;
use Qobo\Social\Provider\ProviderException;
use stdClass;

/**
 * Twitter response
 */
class TwitterResponse extends AbstractResponse
{
    /**
     * {@inheritDoc}
     */
    public function getPosts(): array
    {
        $results = [];
        if (empty($this->payload->results) || !is_array($this->payload->results)) {
            return $results;
        }

        $posts = TableRegistry::getTableLocator()->get('Qobo/Social.Posts');
        foreach ($this->payload->results as $result) {
            /** @var \Qobo\Social\Model\Entity\Post $post */
            $post = $this->getPostEntity($result->id_str);
            $results[] = $this->patchPostEntity($post, $result);
        }

        return $results;
    }

    /**
     * Create an array of interactions based on twitter payload.
     *
     * @param \stdClass $payload Incoming twitter payload
     * @return mixed[] Array of interactions
     */
    protected function createInteractions(stdClass $payload): array
    {
        $result = [];
        $importDate = FrozenTime::now();
        $interactionTypes = TableRegistry::getTableLocator()->get('Qobo/Social.InteractionTypes');
        $postInteractions = TableRegistry::getTableLocator()->get('Qobo/Social.PostInteractions');

        foreach (['retweet_count', 'favorite_count'] as $field) {
            /** @var null|\Qobo\Social\Model\Entity\InteractionType $type */
            $type = $interactionTypes->find('all')->where([
                'network_id' => $this->getNetwork()->id,
                'slug' => $field,
            ])->first();
            if ($type === null) {
                continue;
            }
            $result[] = [
                'interaction_type_id' => $type->get('id'),
                'value_int' => $payload->$field ?? 0,
                'import_date' => $importDate,
            ];
        }

        return $result;
    }

    /**
     * Patches a post entity with twitter payload.
     *
     * @param \Qobo\Social\Model\Entity\Post $post Post entity.
     * @param \stdClass $payload Incoming twitter payload.
     * @return \Qobo\Social\Model\Entity\Post Patched Post entity
     */
    protected function patchPostEntity(Post $post, stdClass $payload): Post
    {
        $posts = TableRegistry::getTableLocator()->get('Qobo/Social.Posts');
        $accounts = TableRegistry::getTableLocator()->get('Qobo/Social.Accounts');

        /** @var \Qobo\Social\Model\Entity\Account $account */
        $account = $this->getAccountEntity($payload->user);
        if ($account->isNew()) {
            $account = $accounts->patchEntity($account, [
                'network_id' => $this->getNetwork()->id,
                'handle' => $payload->user->screen_name,
                'is_ours' => false,
            ]);

            if (!$accounts->save($account)) {
                throw new ProviderException('cannot save account');
            }
        }

        /** @var \Qobo\Social\Model\Entity\Post $post */
        $post = $posts->patchEntity($post, [
            'account_id' => $account->id,
            'external_post_id' => $payload->id_str,
            'type' => 'tweet',
            'url' => sprintf('https://twitter.com/%s/status/%s', $account->get('handle'), $payload->id_str),
            'subject' => 'Tweet from ' . $account->get('handle'),
            'content' => $payload->text,
            'extra' => json_encode($payload),
            'publish_date' => new FrozenTime($payload->created_at),
            'post_interactions' => $this->createInteractions($payload),
        ], ['validate' => false]);

        return $post;
    }

    /**
     * Returns a post entity.
     *
     * @param string $postId Twitter post id.
     * @return \Qobo\Social\Model\Entity\Post
     */
    protected function getPostEntity(string $postId): Post
    {
        $network = $this->getNetwork();
        $posts = TableRegistry::getTableLocator()->get('Qobo/Social.Posts');
        /** @var \Qobo\Social\Model\Entity\Post $post */
        $post = $posts->newEntity();
        /** @var null|\Qobo\Social\Model\Entity\Post $existingPost */
        $existingPost = $posts->find('all')
            ->where(['external_post_id' => $postId])
            ->matching('Accounts', function ($q) use ($network) {
                return $q->where(['network_id' => $network->id]);
            })
            ->first();

        if ($existingPost !== null) {
            $post = $existingPost;
        }

        return $post;
    }

    /**
     * Returns an account entity based on the tweet.
     *
     * @param \stdClass $twitterAccount Account from twitter reponse.
     * @return \Qobo\Social\Model\Entity\Account
     */
    protected function getAccountEntity(stdClass $twitterAccount): Account
    {
        $network = $this->getNetwork();
        $accounts = TableRegistry::getTableLocator()->get('Qobo/Social.Accounts');
        /** @var \Qobo\Social\Model\Entity\Account $account */
        $account = $accounts->newEntity([]);
        /** @var null|\Qobo\Social\Model\Entity\Account $query */
        $query = $accounts->find('all')
            ->where([
                'network_id' => $network->id,
                'handle' => $twitterAccount->screen_name,
            ])->first();

        if ($query !== null) {
            $account = $query;
        }

        return $account;
    }
}
