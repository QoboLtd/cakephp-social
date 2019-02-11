<?php
namespace Qobo\Social\Test\App\Publisher;

use Qobo\Social\Model\Entity\Post;
use Qobo\Social\Publisher\AbstractPublisher;
use Qobo\Social\Publisher\PublisherException;
use Qobo\Social\Publisher\PublisherResponseInterface;

class PublisherThrows extends AbstractPublisher
{
    /**
     * {@inheritDoc}
     */
    public function publish(Post $post): PublisherResponseInterface
    {
        throw new PublisherException();
    }
}
