<?php
namespace Qobo\Social\Provider;

/**
 * Generic Provider Interface
 */
interface ProviderInterface
{
    /**
     * Sets which network this provider belongs to.
     *
     * @param mixed $network Network.
     * @return void
     */
    public function setNetwork($network): void;
}
