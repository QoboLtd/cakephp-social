<?php
namespace Qobo\Social\Test\App\Publisher;

use Qobo\Social\Model\Entity\Post;
use Qobo\Social\Publisher\AbstractPublisher;
use Qobo\Social\Publisher\PublisherResponseInterface;

class TestPublisher extends AbstractPublisher
{
    /**
     * {@inheritDoc}
     */
    public function publish(Post $post): PublisherResponseInterface
    {
        $response = new TestPublisherResponse(['external_id' => 'test-id']);

        return $response;
    }
}
