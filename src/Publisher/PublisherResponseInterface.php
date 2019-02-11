<?php
namespace Qobo\Social\Publisher;

/**
 * Publisher response interface
 */
interface PublisherResponseInterface
{
    /**
     * Returns the raw response payload from social network.
     *
     * @return mixed
     */
    public function getResponsePayload();

    /**
     * Returns true when the response contains errors.
     *
     * @return bool
     */
    public function hasErrors(): bool;

    /**
     * Returns an array of error messages.
     *
     * @return string[]
     */
    public function getErrors(): array;

    /**
     * Return the ID of the post on the social network.
     *
     * @return string External post ID
     */
    public function getExternalPostId(): string;
}
