<?php
namespace Qobo\Social\Publisher\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;
use Qobo\Social\Model\Entity\Post;
use Qobo\Social\Publisher\AbstractPublisher;
use Qobo\Social\Publisher\PublisherException;
use Qobo\Social\Publisher\PublisherResponseInterface;

/**
 * Publisher interface
 */
class TwitterPublisher extends AbstractPublisher
{
    /**
     * Twitter client.
     * @var \Abraham\TwitterOAuth\TwitterOAuth
     */
    protected $client;

    /**
     * Returns an instance of the twitter client.
     *
     * @return \Abraham\TwitterOAuth\TwitterOAuth Twitter client.
     */
    public function getClient(): TwitterOAuth
    {
        if (!($this->client instanceof TwitterOAuth)) {
            $consumerKey = $this->getNetwork()->get('oauth_consumer_key');
            $consumerSecret = $this->getNetwork()->get('oauth_consumer_secret');
            $credentials = json_decode($this->getAccount()->get('credentials'));
            $oauthToken = $credentials->oauth_token ?? '';
            $oauthSecret = $credentials->oauth_token_secret ?? '';
            // $oauthSecret = 'bad';
            $this->client = new TwitterOAuth($consumerKey, $consumerSecret, $oauthToken, $oauthSecret);
        }

        return $this->client;
    }

    /**
     * {@inheritDoc}
     */
    public function publish(Post $post): PublisherResponseInterface
    {
        $contents = $post->get('content');

        $payload = [
            'status' => $contents,
        ];

        $result = $this->callApi($payload);
        $response = new TwitterPublisherResponse($result);

        return $response;
    }

    /**
     * Wrapper around api calling, so it can be mocked.
     *
     * @param mixed[] $options Options.
     * @return mixed
     * @throws \Qobo\Social\Provider\ProviderException
     */
    protected function callApi(array $options)
    {
        // @codeCoverageIgnoreStart
        try {
            return $this->getClient()->post("statuses/update", $options);
        } catch (TwitterOAuthException $e) {
            throw new PublisherException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd
    }
}
