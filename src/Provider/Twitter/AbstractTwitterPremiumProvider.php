<?php
namespace Qobo\Social\Provider\Twitter;

use Cake\Core\InstanceConfigTrait;
use InvalidArgumentException;

/**
 * Twitter 30day search premium API
 *
 * @see https://developer.twitter.com/en/docs/tweets/search/api-reference/premium-search.html
 */
abstract class AbstractTwitterPremiumProvider extends AbstractTwitterProvider
{
    use InstanceConfigTrait;

    /**
     * {@inheritDoc}
     */
    protected $_defaultConfig = [
        'archiveType' => '30day',
        'env' => '',
    ];

    /**
     * List of valid archive types.
     *
     * @see https://developer.twitter.com/en/docs/tweets/search/api-reference/premium-search.html
     * @var array
     */
    const VALID_ARCHIVE_TYPES = [
        '30day',
        'fullarchive',
    ];

    /**
     * Wrapper function to call the twitter client.
     *
     * @param mixed[] $options Query options
     * @return mixed
     * @throws \InvalidArgumentException When the archive type is invalid or the environment is not set.
     */
    protected function searchTweets(array $options = [])
    {
        $archiveType = $this->getConfig('archiveType');
        $env = $this->getConfig('env');

        if (!in_array($archiveType, self::VALID_ARCHIVE_TYPES)) {
            throw new InvalidArgumentException("The archive type `{$archiveType}` is not valid.");
        }
        if (empty($env)) {
            throw new InvalidArgumentException("The environment parameter is mandatory.");
        }

        return $this->callApi($archiveType, $env, $options);
    }

    /**
     * Wrapper around api calling, so it can be mocked.
     *
     * @param string $archiveType Archive type.
     * @param string $env Environment name.
     * @param mixed[] $options Options.
     * @return mixed
     */
    protected function callApi(string $archiveType, string $env, array $options)
    {
        // @codeCoverageIgnoreStart
        return $this->getClient()->get("tweets/search/{$archiveType}/{$env}", $options);
        // @codeCoverageIgnoreEnd
    }

    /**
     * Parses options for searching tweets.
     *
     * Valid options are:
     *      query - Query string
     *      maxResults - Limit the number of returned results
     *      fromDate - From date
     *      toDate - To date
     *
     * @param mixed[] $options Options.
     * @return mixed[] Formatted options array
     */
    protected function parseOptions(array $options = []): array
    {
        $defaults = [
            'query' => '',
            'maxResults' => 100,
            'fromDate' => '',
            'toDate' => '',
        ];

        // Apply defaults
        $result = $options + $defaults;
        $result = array_intersect_key($result, $defaults);

        return $result;
    }
}
