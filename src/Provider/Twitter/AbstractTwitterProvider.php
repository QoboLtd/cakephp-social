<?php
namespace Qobo\Social\Provider\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Qobo\Social\Provider\ProviderInterface;

/**
 * Twitter 30day search premium API
 *
 * @see https://developer.twitter.com/en/docs/tweets/search/api-reference/premium-search.html
 */
abstract class AbstractTwitterProvider implements ProviderInterface
{
    /**
     * Consumer key.
     * @var string
     */
    protected $consumerKey;

    /**
     * Consumer key secret.
     * @var string
     */
    protected $consumerSecret;

    /**
     * Twitter client.
     * @var \Abraham\TwitterOAuth\TwitterOAuth
     */
    protected $client;

    /**
     * {@inheritDoc}
     */
    public function setCredentials(string $consumerKey, string $consumerSecret): void
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
    }

    /**
     * Returns an instance of the twitter client.
     *
     * @return \Abraham\TwitterOAuth\TwitterOAuth Twitter client.
     */
    public function getClient(): TwitterOAuth
    {
        if (!($this->client instanceof TwitterOAuth)) {
            $this->client = new TwitterOAuth($this->consumerKey, $this->consumerSecret);
        }

        return $this->client;
    }

    /**
     * {@inheritDoc}
     */
    abstract public function read(array $options = []);
}
