<?php
namespace Qobo\Social\Test\TestCase\Event\Twitter;

use Cake\Event\Event;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
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
     * Mock OAuth token
     *
     * @var string
     */
    const OAUTH_TOKEN = 'some_oauth_token_value';

    /**
     * Mock OAuth token secret
     *
     * @var string
     */
    const OAUTH_TOKEN_SECRET = 'some_oauth_token_secret_value';

    /**
     * Mock OAuth verifier
     *
     * @var string
     */
    const OAUTH_VERIFIER = 'some_oauth_verifier';

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
        /** @var \PHPUnit\Framework\MockObject\MockObject&\Abraham\TwitterOAuth\TwitterOAuth $connection */
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
        /** @var \PHPUnit\Framework\MockObject\MockObject&\Abraham\TwitterOAuth\TwitterOAuth $connection */
        $connection = $this->getConnectionMock();
        $token = [
            'oauth_token' => self::OAUTH_TOKEN,
            'oauth_token_secret' => self::OAUTH_TOKEN_SECRET,
        ];
        $connection->expects($this->once())
            ->method('oauth')
            ->will($this->returnValue($token));
        $this->Listener->setConnection($connection);

        /** @var \Cake\Http\Response */
        $response = $this->Listener->connect($event, $request);
        $this->assertInstanceOf('Cake\Http\Response', $response);

        $session = $request->getSession()->read('Twitter.connectAccount');
        $this->assertEquals($token['oauth_token'], $session['oauthToken']);
        $this->assertEquals($token['oauth_token_secret'], $session['oauthTokenSecret']);

        $headers = $response->getHeaders();
        $url = $headers['Location'][0] ?? null;
        $this->assertEquals(self::MOCK_URL, $url);
    }

    /**
     * Test when oauth token from query params doesn't match oauth token in session
     *
     * @return void
     */
    public function testOAuthTokenDoesntMatchSession(): void
    {
        $request = new ServerRequest();
        $event = $this->getEvent($request);
        /** @var \PHPUnit\Framework\MockObject\MockObject&\Abraham\TwitterOAuth\TwitterOAuth $connection */
        $connection = $this->getConnectionMock();
        $session = [
            'oauthToken' => 'bad token',
        ];
        $request->getSession()->write('Twitter.connectAccount', $session);
        $request = $request->withQueryParams([
            'oauth_token' => self::OAUTH_TOKEN,
        ]);

        $connection->expects($this->never())
            ->method('oauth');

        $this->Listener->setConnection($connection);

        /** @var false $response */
        $response = $this->Listener->connect($event, $request);
        $this->assertFalse($response);
    }

    /**
     * Test get access token
     *
     * @return void
     */
    public function testGetAccessToken(): void
    {
        $request = new ServerRequest();
        $event = $this->getEvent($request);
        /** @var \PHPUnit\Framework\MockObject\MockObject&\Abraham\TwitterOAuth\TwitterOAuth $connection */
        $connection = $this->getConnectionMock();
        $session = [
            'oauthToken' => self::OAUTH_TOKEN,
            'oauthTokenSecret' => self::OAUTH_TOKEN_SECRET,
        ];
        $request->getSession()->write('Twitter.connectAccount', $session);
        $request = $request->withQueryParams([
            'oauth_token' => self::OAUTH_TOKEN,
            'oauth_verifier' => self::OAUTH_VERIFIER,
        ]);

        $accessToken = [
            'oauth_token' => self::OAUTH_TOKEN,
            'oauth_token_secret' => self::OAUTH_TOKEN_SECRET,
            'user_id' => 123456,
            'screen_name' => 'foobar',
        ];
        $connection->expects($this->once())
            ->method('oauth')
            ->will($this->returnValue($accessToken));

        $this->Listener->setConnection($connection);

        /** @var \Qobo\Social\Model\Entity\Account $response */
        $response = $this->Listener->connect($event, $request);
        $this->assertInstanceOf('Qobo\Social\Model\Entity\Account', $response);
        $this->assertTrue($response->isNew());
        $this->assertEquals(json_encode($accessToken), $response->credentials);
    }

    /**
     * Returns a twitter connection mock object.
     *
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function getConnectionMock(): MockObject
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
