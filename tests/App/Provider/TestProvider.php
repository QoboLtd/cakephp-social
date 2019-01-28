<?php
namespace Qobo\Social\Test\App\Provider;

use Cake\Core\InstanceConfigTrait;
use Qobo\Social\Provider\ProviderInterface;

/**
 * Test Provider
 */
class TestProvider implements ProviderInterface
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
     * Default config.
     * @var mixed[]
     */
    protected $_defaultConfig = [
        'foo' => 'bar',
    ];

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
    public function read(array $options = [])
    {
        return $this->getConfig('foo');
    }
}
