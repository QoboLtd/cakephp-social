<?php
namespace Qobo\Social\Provider\Twitter;

/**
 * Twitter Premium Search Provider
 *
 * @see https://developer.twitter.com/en/docs/tweets/search/api-reference/premium-search.html
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
