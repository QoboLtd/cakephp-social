<?php
namespace Qobo\Social\Test\App\Publisher\Twitter;

use Qobo\Social\Publisher\Twitter\TwitterPublisher as BaseTwitterPublisher;

class TwitterPublisher extends BaseTwitterPublisher
{
    /**
     * Paylaod filename to retreive.
     * @var string
     */
    public $filename = 'twitter_response_publisher';

    /**
     * {@inheritDoc}
     */
    protected function callApi(array $options)
    {
        $file = TESTS . 'data' . DS . $this->filename . '.json';
        $data = (string)file_get_contents($file);

        return json_decode($data);
    }
}
