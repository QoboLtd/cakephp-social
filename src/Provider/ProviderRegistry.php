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
     * @var \Qobo\Social\Provider\ProviderInterface[]
     */
    protected $providers = [];

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
        if (!static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Registers a provider.
     *
     * @param string $name Provider's name
     * @param ProviderInterface $provider Provider object.
     * @param bool $overwrite True to overwrite
     * @return void
     * @throws \InvalidArgumentException When `overwrite` flag set to false, and provider already registered.
     */
    public function set(string $name, ProviderInterface $provider, bool $overwrite = false): void
    {
        if ($overwrite === false && $this->exists($name)) {
            throw new InvalidArgumentException("Provider `{$name}` has already been registered. Set `overwrite` to ignore.");
        }

        $this->providers[$name] = $provider;
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
        if (!$this->exists($name)) {
            throw new InvalidArgumentException("Provider `{$name}` is not registered.");
        }

        return $this->providers[$name];
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
