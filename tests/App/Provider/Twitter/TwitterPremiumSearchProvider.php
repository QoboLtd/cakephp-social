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
        $filename = $this->getConfig('filename');
        $file = TESTS . 'data' . DS . $filename . '.json';
        $data = (string)file_get_contents($file);

        return json_decode($data);
    }
}
