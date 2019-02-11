<?php
namespace Qobo\Social\Test\App\Publisher;

use Qobo\Social\Publisher\AbstractPublisherResponse;

class TestPublisherResponse extends AbstractPublisherResponse
{
    /**
     * Sample error message
     * @var string
     */
    const ERROR_MESSAGE = 'empty payload';

    /**
     * Response payload
     * @var mixed
     */
    protected $payload;

    /**
     * Class constructor
     * @param mixed $payload Twitter payload.
     */
    public function __construct($payload)
    {
        $this->payload = $payload;

        if (empty($payload)) {
            $this->errors[] = self::ERROR_MESSAGE;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getExternalPostId(): string
    {
        return $this->payload['external_id'] ?? '';
    }
}
