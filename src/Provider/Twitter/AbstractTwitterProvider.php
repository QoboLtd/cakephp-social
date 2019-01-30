<?php
namespace Qobo\Social\Provider\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Qobo\Social\Model\Entity\Network;
use Qobo\Social\Model\Entity\Topic;
use Qobo\Social\Provider\ProviderInterface;
use Qobo\Social\Provider\ResponseInterface;
use Qobo\Social\Provider\TopicProviderInterface;

/**
 * Abstract Twitter Provider
 *
 * @see https://developer.twitter.com/en/docs/tweets/search/api-reference/premium-search.html
 */
abstract class AbstractTwitterProvider implements ProviderInterface, TopicProviderInterface
{
    /**
     * Network entity.
     * @var \Qobo\Social\Model\Entity\Network
     */
    protected $network;

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
     * Topic entity
     * @var \Qobo\Social\Model\Entity\Topic
     */
    protected $topic;

    /**
     * {@inheritDoc}
     */
    public function setNetwork(Network $network): void
    {
        $this->network = $network;
    }

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
    public function setTopic(Topic $topic): void
    {
        $this->topic = $topic;
    }

    /**
     * {@inheritDoc}
     */
    public function getTopic(): Topic
    {
        return $this->topic;
    }

    /**
     * {@inheritDoc}
     */
    abstract public function read(array $options = []): ResponseInterface;
}
