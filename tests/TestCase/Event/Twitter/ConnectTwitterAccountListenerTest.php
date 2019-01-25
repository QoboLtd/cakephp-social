<?php
namespace Qobo\Social\Test\TestCase\Event\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Cake\Event\Event;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Qobo\Social\Event\EventName;
use Qobo\Social\Event\Twitter\ConnectTwitterAccountListener;
use RuntimeException;

/**
 * Qobo\Social\Event\Twitter\ConnectTwitterAccountListener Test Case
 */
class ConnectTwitterAccountListenerTest extends TestCase
{

    /**
     * Mock url
     *
     * @var string
     */
    const MOCK_URL = 'https://api.twitter.com/some/endpoint';

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
     * Listener
     *
     * @var \Qobo\Social\Event\Twitter\ConnectTwitterAccountListener
     */
    protected $Listener;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->Listener = new ConnectTwitterAccountListener();
    }

    /**
     * {@inheritDoc}
     */
    public function tearDown(): void
    {
        unset($this->Listener);

        parent::tearDown();
    }

    /**
     * Test twitter connection setter/getter
     *
     * @return void
     */
    public function testSetGetTwitterConnection(): void
    {
        $connection = $this->getConnectionMock();
        $this->Listener->setConnection($connection);
        $this->assertSame($connection, $this->Listener->getConnection());
    }

    /**
     * Test twitter connection getter returns new instance
     *
     * @return void
     */
    public function testGetTwitterConnectionWhenNotSet(): void
    {
        $connection = $this->Listener->getConnection();
        $this->assertInstanceOf('Abraham\TwitterOAuth\TwitterOAuth', $connection);
    }

    /**
     * Test twitter network getter fails when network cannot be found
     *
     * @return void
     */
    public function testGetTwitterNetworkGetterFail(): void
    {
        $this->expectException(RuntimeException::class);
        $networks = TableRegistry::getTableLocator()->get('Networks');
        $networks->deleteAll(['name' => ConnectTwitterAccountListener::NETWORK_NAME]);
        $network = $this->Listener->getNetwork();
    }

    /**
     * Test get request token
     *
     * @return void
     */
    public function testGetRequestToken(): void
    {
        $request = new ServerRequest();
        $event = $this->getEvent($request);
        $connection = $this->getConnectionMock();
        $token = [
            'oauth_token' => 'token',
            'oauth_token_secret' => 'secret',
        ];
        $conection->expects($this->once())
            ->method('oauth')
            ->will($this->returnValue($token));

        $this->Listener->setConnection($connection);
        $response = $this->Listener->connect($event, $request);
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

    /**
     * Returns an event object.
     *
     * @param \Cake\Http\ServerRequest $request Request object.
     * @return \Cake\Event\Event
     */
    protected function getEvent(ServerRequest $request): Event
    {
        $event = new Event((string)EventName::QOBO_SOCIAL_CONNECT_TWITTER(), $this, [$request]);

        return $event;
    }
}
