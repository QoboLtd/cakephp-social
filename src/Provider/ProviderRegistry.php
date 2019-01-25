<?php
namespace Qobo\Social\Provider;

use Cake\Collection\Collection;
use InvalidArgumentException;

/**
 * Provider Registry singleton class
 */
class ProviderRegistry
{
    /**
     * Singleton instance.
     * @var \Qobo\Social\Provider\ProviderRegistry
     */
    protected static $instance;

    /**
     * Registered providers
     * @var mixed[]
     */
    protected $providers = [];

    /**
     * Registered provider instances
     * @var \Qobo\Social\Provider\ProviderInterface[]
     */
    protected $providerInstances = [];

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
     * Registers a provider.
     *
     * @param string $name Provider's name
     * @param string|array $provider Provider class name, or array of class name and config.
     * @param bool $overwrite True to overwrite
     * @return void
     * @throws \InvalidArgumentException When `overwrite` flag set to false, and provider already registered.
     */
    public function set(string $name, $provider, bool $overwrite = false): void
    {
        if ($overwrite === false && isset($this->providers[$name])) {
            throw new InvalidArgumentException("Provider `{$name}` has already been registered. Set `overwrite` to ignore.");
        }

        $definition = $this->getProviderConfig($provider);
        $this->providers[$name] = $definition;
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
     * Returns the provider.
     *
     * @param string $name Provider's name
     * @return \Qobo\Social\Provider\ProviderInterface Provider object.
     * @throws \InvalidArgumentException When provider is not registered.
     */
    public function get(string $name): ProviderInterface
    {
        if (!isset($this->providers[$name])) {
            throw new InvalidArgumentException("Provider `{$name}` is not registered.");
        }

        if (!isset($this->providerInstances[$name])) {
            $className = $this->providers[$name]['className'];
            $providerConfig = $this->providers[$name]['config'];
            $class = new $className($providerConfig);

            $uses = class_uses($class);
            if (in_array('Cake\Core\InstanceConfigTrait', $uses)) {
                /** @var \Cake\Core\InstanceConfigTrait $class */
                $class->setConfig($providerConfig);
            }
            $this->providerInstances[$name] = $class;
        }

        return $this->providerInstances[$name];
    }

    /**
     * Removes the given provider
     *
     * @param string $name Provider's name
     * @return void
     */
    public function remove(string $name): void
    {
        unset($this->providers[$name]);
    }

    /**
     * Check whether the provider has been previously registered.
     *
     * @param string $name Provider's name
     * @return bool True if registered
     */
    public function exists(string $name): bool
    {
        return isset($this->providers[$name]);
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
