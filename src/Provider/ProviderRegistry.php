<?php
namespace Qobo\Social\Provider;

use Cake\Collection\Collection;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;
use InvalidArgumentException;
use Qobo\Social\Model\Entity\Network;
use Qobo\Social\Utility\ClassUtility;

/**
 * Provider Registry singleton class
 */
class ProviderRegistry
{
    /**
     * Singleton instance.
     * @var \Qobo\Social\Provider\ProviderRegistry|null
     */
    private static $instance;

    /**
     * Registered providers
     * @var mixed[]
     */
    protected $providers = [];

    /**
     * Registered provider instances
     * @var mixed[]
     */
    protected $providerInstances = [];

    // @codeCoverageIgnoreStart
    /**
     * Private constructor.
     */
    private function __construct()
    {
    }

    /**
     * Protect from cloning.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Protect from serialization.
     *
     * @return void
     */
    private function __wakeup()
    {
    }
    // @codeCoverageIgnoreEnd

    /**
     * Returns a singleton instance of ProviderRegistry.
     *
     * @return \Qobo\Social\Provider\ProviderRegistry
     */
    public static function getInstance(): ProviderRegistry
    {
        if (!(static::$instance instanceof self)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Resets the instance.
     *
     * @return void
     */
    public static function clearRegistry(): void
    {
        self::getInstance()->clear();
    }

    /**
     * Resets the instance.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->providers = [];
        $this->providerInstances = [];
    }

    /**
     * Registers a provider.
     *
     * @param string|\Qobo\Social\Model\Entity\Network $network Network name or entity.
     * @param string $name Provider name
     * @param string|array $provider Provider class name, or array of class name and config.
     * @param bool $overwrite True to overwrite
     * @return void
     * @throws \InvalidArgumentException When `overwrite` flag set to false, and provider already registered.
     */
    public function set($network, string $name, $provider, bool $overwrite = false): void
    {
        $network = $this->getNetwork($network);
        if ($overwrite === false && isset($this->providers[$network->name][$name])) {
            throw new InvalidArgumentException("Provider `{$name}` for network `{$network->name}` has already been registered. Set `overwrite` to ignore.");
        }

        $definition = $this->getProviderConfig($provider);
        $this->providers[$network->name][$name] = $definition;
    }

    /**
     * Returns the full provider config.
     *
     * @param string|array $provider Provider class name, or array of class name and config.
     * @return mixed[] Provider config.
     */
    protected function getProviderConfig($provider): array
    {
        $providerConfig = [
            'className' => '',
            'config' => [],
        ];

        if (!is_string($provider) && !is_array($provider)) {
            throw new InvalidArgumentException('Provider must be a string class name, or array of class name and config.');
        }

        $className = $provider;
        if (is_array($provider)) {
            $className = $provider['className'] ?? '';
        }
        if (!class_exists($className)) {
            throw new InvalidArgumentException("Provider class `$className` does not exist.");
        }
        $providerConfig['className'] = $className;

        if (!empty($provider['config'])) {
            $providerConfig['config'] = $provider['config'];
        }

        return $providerConfig;
    }

    /**
     * Returns the network model instance.
     *
     * @param string|\Qobo\Social\Model\Entity\Network $network Network name or entity.
     * @return \Qobo\Social\Model\Entity\Network Network entity.
     * @throws \InvalidArgumentException When the network is neither an entity or a string.
     */
    protected function getNetwork($network): Network
    {
        if ($network instanceof Network) {
            return $network;
        }

        if (!is_string($network)) {
            throw new InvalidArgumentException('Network must be a string or `\Qobo\Social\Model\Entity\Network` class.');
        }

        $networks = TableRegistry::getTableLocator()->get('Qobo/Social.Networks');
        $query = $networks->find('decrypt')->where(['name' => $network]);
        if ($query->count() === 0) {
            throw new RecordNotFoundException("Network `$network` is not present in the database.");
        }
        /** @var \Qobo\Social\Model\Entity\Network $result */
        $result = $query->first();

        return $result;
    }

    /**
     * Returns the provider.
     *
     * @param string $network Network name.
     * @param string $name Provider name.
     * @return \Qobo\Social\Provider\ProviderInterface Provider object.
     * @throws \InvalidArgumentException When provider is not registered.
     */
    public function get(string $network, string $name): ProviderInterface
    {
        if (!isset($this->providers[$network][$name])) {
            throw new InvalidArgumentException("Provider `{$name}` for network `{$network}` is not registered.");
        }

        if (!isset($this->providerInstances[$network][$name])) {
            $this->providerInstances[$network][$name] = $this->createProviderInstance($network, $name);
        }

        return $this->providerInstances[$network][$name];
    }

    /**
     * Creates a provider instance.
     *
     * @param string $network Network name.
     * @param string $name Provider name
     * @return \Qobo\Social\Provider\ProviderInterface Provider object.
     */
    protected function createProviderInstance(string $network, string $name): ProviderInterface
    {
        $className = $this->providers[$network][$name]['className'];
        $providerConfig = $this->providers[$network][$name]['config'];
        $class = new $className($providerConfig);

        /** @var array $uses */
        $uses = ClassUtility::classUses($class, true);
        if (in_array('Cake\Core\InstanceConfigTrait', $uses)) {
            /** @var \Cake\Core\InstanceConfigTrait $class */
            $class->setConfig($providerConfig);
        }

        return $class;
    }

    /**
     * Removes the given provider
     *
     * @param string $network Network name.
     * @param string $name Provider name
     * @return void
     */
    public function remove(string $network, string $name): void
    {
        unset($this->providers[$network][$name]);
        unset($this->providerInstances[$network][$name]);
    }

    /**
     * Check whether the provider has been previously registered.
     *
     * @param string $network Network name.
     * @param string $name Provider name
     * @return bool True if registered
     */
    public function exists(string $network, string $name): bool
    {
        return isset($this->providers[$network][$name]);
    }

    /**
     * Returns a {@link \Cake\Collection\Collection} of registered providers.
     *
     * @return \Cake\Collection\Collection
     */
    public function getCollection(): Collection
    {
        return new Collection($this->providers);
    }
}
