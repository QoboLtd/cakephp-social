<?php
namespace Qobo\Social\Test\App\Provider\Twitter;

use Qobo\Social\Provider\Twitter\TwitterPremiumSearchProvider as BaseProvider;

/**
 * TwitterPremiumSearchProvider for testing purposes
 */
class TwitterPremiumSearchProvider extends BaseProvider
{
    /**
     * {@inheritDoc}
     */
    protected function callApi(string $archiveType, string $env, array $options)
    {
        return true;
    }
}
