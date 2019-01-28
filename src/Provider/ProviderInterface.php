<?php
namespace Qobo\Social\Provider;

/**
 * Generic Provider Interface
 */
interface ProviderInterface
{
    /**
     * Sets the provider consumer credentials.
     *
     * @param string $key Consumer key.
     * @param string $secret Consumer secret.
     * @return void
     */
    public function setCredentials(string $key, string $secret): void;

    /**
     * Reads the provider endpoint data.
     *
     * @return mixed
     */
    public function read();
}
