<?php
namespace Qobo\Social\Test\App\Provider;

use Cake\Core\InstanceConfigTrait;
use Qobo\Social\Model\Entity\Network;
use Qobo\Social\Model\Entity\Topic;
use Qobo\Social\Provider\ProviderInterface;
use Qobo\Social\Provider\ResponseInterface;
use Qobo\Social\Provider\TopicProviderInterface;

/**
 * Test Provider
 */
class TestProvider implements ProviderInterface, TopicProviderInterface
{
    use InstanceConfigTrait;

    /**
     * Consumer key
     * @var string
     */
    protected $consumerKey;

    /**
     * Consumer secret
     * @var string
     */
    protected $consumerSecret;

    /**
     * Network entity.
     * @var \Qobo\Social\Model\Entity\Network
     */
    protected $network;

    /**
     * Topic entity.
     * @var \Qobo\Social\Model\Entity\Topic
     */
    protected $topic;

    /**
     * Default config.
     * @var mixed[]
     */
    protected $_defaultConfig = [
        'foo' => 'bar',
    ];

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
    public function setCredentials(string $key, string $secret): void
    {
        $this->consumerKey = $key;
        $this->consumerSecret = $secret;
    }

    /**
     * Returns the consumer key
     *
     * @return string
     */
    public function getConsumerKey(): string
    {
        return $this->consumerKey;
    }

    /**
     * Returns the consumer secret
     *
     * @return string
     */
    public function getConsumerSecret(): string
    {
        return $this->consumerSecret;
    }

    /**
     * {@inheritDoc}
     */
    public function read(array $options = []): ResponseInterface
    {
        $response = new TestResponse();
        $response->setPayload($this->getConfig('foo'));
        $response->setNetwork($this->network);

        return $response;
    }
}
