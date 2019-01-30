<?php
namespace Qobo\Social\Provider;

use Qobo\Social\Model\Entity\Network;

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
     * Sets the network entity.
     *
     * @param \Qobo\Social\Model\Entity\Network $network Network entity.
     * @return void
     */
    public function setNetwork(Network $network): void;

    /**
     * Reads the provider endpoint data.
     *
     * @param mixed[] $options Options array.
     * @return ResponseInterface
     */
    public function read(array $options = []): ResponseInterface;
}
