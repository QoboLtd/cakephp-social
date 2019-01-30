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
        if (empty($this->payload->results)) {
            return $results;
        }

        $posts = TableRegistry::getTableLocator()->get('Qobo/Social.Posts');
        $accounts = TableRegistry::getTableLocator()->get('Qobo/Social.Accounts');
        $networks = TableRegistry::getTableLocator()->get('Qobo/Social.Networks');

        foreach (array_slice($this->payload->results, 0, 100) as $result) {
            $post = $this->getPostEntity($result->id_str);

            if (!$post->isNew()) {
                continue;
            }

            /** @var \Qobo\Social\Model\Entity\Account $account */
            $account = $this->getAccountEntity($result->user);
            if ($account->isNew()) {
                $account = $accounts->patchEntity($account, [
                    'network_id' => $this->getNetwork()->id,
                    'handle' => $result->user->screen_name,
                    'is_ours' => false,
                ]);

                if (!$accounts->save($account)) {
                    throw new ProviderException('cannot save account');
                }
            }

            /** @var \Qobo\Social\Model\Entity\Post $post */
            $post = $posts->patchEntity($post, [
                'account_id' => $account->id,
                'external_post_id' => $result->id_str,
                'type' => 'tweet',
                'url' => sprintf('https://twitter.com/%s/status/%s', $account->get('handle'), $result->id_str),
                'subject' => 'Tweet from ' . $account->get('handle'),
                'content' => $result->text,
                'extra' => json_encode($result),
                'publish_date' => new FrozenTime($result->created_at),
            ]);

            $results[] = $post;
        }

        return $results;
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
