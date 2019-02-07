<?php
namespace Qobo\Social\Publisher;

use Qobo\Social\Model\Entity\Account;
use Qobo\Social\Model\Entity\Network;
use Qobo\Social\Model\Entity\Post;

/**
 * Publisher interface
 */
interface PublisherInterface
{
    /**
     * Network entity setter.
     *
     * @param \Qobo\Social\Model\Entity\Network $network Network entity.
     * @return void
     */
    public function setNetwork(Network $network): void;

    /**
     * Network entity getter.
     *
     * @return \Qobo\Social\Model\Entity\Network Network entity.
     */
    public function getNetwork(): Network;

    /**
     * Account entity setter.
     *
     * @param \Qobo\Social\Model\Entity\Account $account Account entity.
     * @return void
     */
    public function setAccount(Account $account): void;

    /**
     * Account entity getter.
     *
     * @return \Qobo\Social\Model\Entity\Account Account entity.
     */
    public function getAccount(): Account;

    /**
     * Publish the post to social network.
     *
     * @param \Qobo\Social\Model\Entity\Post $post Post entity.
     * @return \Qobo\Social\Publisher\PublisherResponseInterface Publisher response
     */
    public function publish(Post $post): PublisherResponseInterface;
}
