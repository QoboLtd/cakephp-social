<?php
namespace Qobo\Social\Provider;

use Qobo\Social\Model\Entity\Network;

/**
 * Generic provider response interface.
 */
interface ResponseInterface
{
    /**
     * Sets the response payload.
     *
     * @param mixed $data Payload.
     * @return void
     */
    public function setPayload($data): void;

    /**
     * Returns the payload.
     *
     * @return mixed Payload
     */
    public function getPayload();

    /**
     * Sets the network entity.
     *
     * @param \Qobo\Social\Model\Entity\Network $network Network entity.
     * @return void
     */
    public function setNetwork(Network $network): void;

    /**
     * Returns the network entity.
     *
     * @return \Qobo\Social\Model\Entity\Network $network Network entity.
     */
    public function getNetwork(): Network;

    /**
     * Returns a collection of post entities derived from the payload.
     *
     * @return \Qobo\Social\Model\Entity\Post[] Post entities.
     */
    public function getPosts(): array;
}
