<?php
namespace Qobo\Social\Provider\Twitter;

/**
 * Twitter 30day search premium API
 *
 * @see https://developer.twitter.com/en/docs/tweets/search/quick-start/premium-30-day.html
 */
class TwitterPremiumSearchProvider extends AbstractTwitterPremiumProvider
{
    /**
     * {@inheritDoc}
     */
    public function read(array $options = [])
    {
        $config = $this->parseOptions($options);

        return $this->searchTweets($config);
    }
}
