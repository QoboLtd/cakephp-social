<?php
namespace Qobo\Social\Publisher;

/**
 * Publisher response interface
 */
abstract class AbstractPublisherResponse implements PublisherResponseInterface
{
    /**
     * Errors
     *
     * @var string[]
     */
    protected $errors = [];

    /**
     * {@inheritDoc}
     */
    abstract public function getResponsePayload();

    /**
     * {@inheritDoc}
     */
    public function hasErrors(): bool
    {
        return (bool)count($this->errors);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * {@inheritDoc}
     */
    abstract public function getExternalPostId(): string;
}
