<?php
namespace Qobo\Social\Test\TestCase\Event\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;

use Cake\TestSuite\TestCase;

/**
 * Qobo\Social\Event\Twitter\ConnectTwitterAccountListenerTest Test Case
 */
class ConnectTwitterAccountListenerTest extends TestCase
{

    /**
     * Mock url
     *
     * @var string
     */
    const MOCK_URL = 'https://google.com';

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/social.networks',
        'plugin.qobo/social.accounts',
    ];

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * {@inheritDoc}
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Returns a twitter connection mock object.
     *
     * @return \Abraham\TwitterOAuth\TwitterOAuth
     */
    protected function getConnectionMock(): TwitterOAuth
    {
        $connection = $this->getMockBuilder('Abraham\TwitterOAuth\TwitterOAuth')
            ->setConstructorArgs(['consumerKey', 'consumerSecret'])
            ->setMethods(['url', 'oauth', 'setOauthToken'])
            ->getMock();

        $connection->expects($this->any())
            ->method('url')
            ->will($this->returnValue(self::MOCK_URL));

        return $connection;
    }
}
