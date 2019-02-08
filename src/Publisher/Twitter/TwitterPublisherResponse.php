<?php
namespace Qobo\Social\Publisher\Twitter;

use Qobo\Social\Publisher\AbstractPublisherResponse;

class TwitterPublisherResponse extends AbstractPublisherResponse
{
    /**
     * Class constructor
     * @param mixed $payload Twitter payload.
     */
    public function __construct($payload)
    {
        $this->payload = $payload;

        if (empty($payload) || !empty($payload->errors)) {
            $this->errors = $payload->errors ?? [];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getExternalPostId(): string
    {
        return $this->payload->id_str ?? '';
    }
}
