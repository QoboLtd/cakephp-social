<?php
namespace Qobo\Social\Provider\Twitter;

use Qobo\Social\Provider\ResponseInterface;

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
    public function read(array $options = []): ResponseInterface
    {
        $queryString = implode(' OR ', $this->getKeywords());
        $options['query'] = $queryString;
        $config = $this->parseOptions($options);
        $payload = $this->searchTweets($config);

        $response = new TwitterResponse();
        $response->setPayload($payload);
        $response->setNetwork($this->network);

        return $response;
    }

    /**
     * Returns an array of keyword names based on topic.
     *
     * @return string[] Keyword names.
     */
    protected function getKeywords(): array
    {
        $topic = $this->getTopic();
        $keywords = [];
        if (!empty($topic->keywords)) {
            $keywords = collection($topic->keywords)->extract('name')->toArray();
        }

        return $keywords;
    }
}
