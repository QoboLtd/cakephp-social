<?php
namespace Qobo\Social\Provider;

use Qobo\Social\Model\Entity\Network;
use Qobo\Social\Provider\ResponseInterface;

/**
 * Abstract response
 */
abstract class AbstractResponse implements ResponseInterface
{
    /**
     * Twitter payload
     * @var mixed
     */
    protected $payload;

    /**
     * Network entity
     * @var \Qobo\Social\Model\Entity\Network
     */
    protected $network;

    /**
     * {@inheritDoc}
     */
    public function setPayload($data): void
    {
        $this->payload = $data;
    }

    /**
     * {@inheritDoc}
     */
    public function getPayload()
    {
        return $this->payload;
    }

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
    public function getNetwork(): Network
    {
        return $this->network;
    }

    /**
     * {@inheritDoc}
     */
    abstract public function getPosts(): array;
}
