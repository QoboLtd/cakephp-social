<?php
namespace Qobo\Social\Publisher;

use Qobo\Social\Model\Entity\Account;
use Qobo\Social\Model\Entity\Network;

/**
 * Publisher interface
 */
abstract class AbstractPublisher implements PublisherInterface
{
    /**
     * Network object.
     * @var \Qobo\Social\Model\Entity\Network
     */
    protected $network;

    /**
     * Account object.
     * @var \Qobo\Social\Model\Entity\Account
     */
    protected $account;

    /**
     * {@inheritDoc}
     */
    public function setNetwork(Network $network): void
    {
        $this->network = $network;
    }

    /**
     * Network entity getter.
     *
     * @return \Qobo\Social\Model\Entity\Network Network entity.
     */
    public function getNetwork(): Network
    {
        return $this->network;
    }

    /**
     * {@inheritDoc}
     */
    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }

    /**
     * Account entity getter.
     *
     * @return \Qobo\Social\Model\Entity\Account Account entity.
     */
    public function getAccount(): Account
    {
        return $this->account;
    }
}
