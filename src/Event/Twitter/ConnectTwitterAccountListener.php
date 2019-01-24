<?php
namespace Qobo\Social\Event\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Qobo\Social\Event\EventName;
use Qobo\Social\Model\Entity\Account;
use Qobo\Social\Model\Entity\Network;
use RuntimeException;

/**
 * LiveChatInc event listener
 */
class ConnectTwitterAccountListener implements EventListenerInterface
{
    /**
     * Network name
     * @var string
     */
    const NETWORK_NAME = 'twitter';

    /**
     * Twitter network entity.
     * @var \Qobo\Social\Model\Entity\Network
     */
    protected $network;

    /**
     * Twitter oauth connection.
     * @var \Abraham\TwitterOAuth\TwitterOAuth
     */
    protected $connection;

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->network = $this->getNetwork();
    }

    /**
     * {@inheritDoc}
     */
    public function implementedEvents()
    {
        return [
            (string)EventName::QOBO_SOCIAL_CONNECT_TWITTER() => 'connect'
        ];
    }

    /**
     * Connect a twitter account and save the oauth credentials into session
     *
     * @link https://developer.twitter.com/en/docs/basics/authentication/overview/3-legged-oauth
     * @param \Cake\Event\Event $event Event object
     * @param \Cake\Http\ServerRequest $request Request object.
     * @return \Cake\Http\Response|\Qobo\Social\Model\Entity\Account|bool
     *  Response object if a redirect is required, Account model to create a new account
     *  or false when the event fails.
     */
    public function connect(Event $event, ServerRequest $request)
    {
        $session = $request->getSession();

        // Step 1: Get the oauth token
        $oauthToken = $request->getQuery('oauth_token');
        if (empty($oauthToken)) {
            $requestToken = $this->getRequestToken();
            $session->write([
                'Twitter.connectAccount.oauthToken' => $requestToken['oauth_token'],
                'Twitter.connectAccount.oauthTokenSecret' => $requestToken['oauth_token_secret'],
            ]);
            $url = $this->getConnection()->url('oauth/authorize', ['oauth_token' => $requestToken['oauth_token']]);
            $response = new Response();

            return $response->withLocation($url);
        }

        // Step 2: Authorize with oauth token
        $data = $session->consume('Twitter.connectAccount');
        if ($oauthToken === $data['oauthToken']) {
            $oauthVerifier = $request->getQuery('oauth_verifier');

            // Step 3: Get the access token
            $accessToken = $this->getAccessToken($data['oauthToken'], $data['oauthTokenSecret'], $oauthVerifier);
            $session->write('Twitter.accessToken', $accessToken);

            return $this->registerAccount($accessToken);
        }

        return false;
    }

    /**
     * Returns the twitter network model.
     *
     * @throws \RuntimeException When twitter network cannot be found.
     * @return \Qobo\Social\Model\Entity\Network Network entity.
     */
    protected function getNetwork(): Network
    {
        // Find network and create a new entity
        $networks = TableRegistry::getTableLocator()->get('Qobo/Social.Networks');
        $network = $networks->find('all', ['name' => self::NETWORK_NAME])->find('decrypt');
        if ($network->count() === 0) {
            throw new RuntimeException('Twitter network is not defined in the system.');
        }

        return $network->first();
    }

    /**
     * Returns an instance of twitter oauth connection class.
     *
     * @return \Abraham\TwitterOAuth\TwitterOAuth Twitter connection object.
     */
    protected function getConnection(): TwitterOAuth
    {
        if (!($this->connection instanceof TwitterOAuth)) {
            $this->setConnection();
        }

        return $this->connection;
    }

    /**
     * Creates an instance of twitter oauth connection class.
     *
     * @param \Abraham\TwitterOAuth\TwitterOAuth|null $connection Optional connection object.
     * @return void
     */
    protected function setConnection(?TwitterOAuth $connection = null): void
    {
        if ($connection === null) {
            $consumerKey = $this->network->oauth_consumer_key;
            $consumerSecret = $this->network->oauth_consumer_secret;
            $connection = new TwitterOAuth($consumerKey, $consumerSecret);
        }

        $this->connection = $connection;
    }

    /**
     * Gets the request token from twitter.
     *
     * @throws \Abraham\TwitterOAuth\TwitterOAuthException When the request fails.
     * @return string[] Request token.
     */
    protected function getRequestToken(): array
    {
        $consumerKey = $this->network->oauth_consumer_key;
        $consumerSecret = $this->network->oauth_consumer_secret;
        $connection = new TwitterOAuth($consumerKey, $consumerSecret);
        $callbackUrl = Router::url(
            [
                'plugin' => 'Qobo/Social',
                'controller' => 'Accounts',
                'action' => 'connect',
                self::NETWORK_NAME
            ],
            true
        );

        return $this->getConnection()->oauth('oauth/request_token', ['oauth_callback' => $callbackUrl]);
    }

    /**
     * Gets the access token from twitter.
     *
     * @param string $oauthToken Oauth Token.
     * @param string $oauthTokenSecret Oauth Token Secret.
     * @param string $oauthVerifier Oauth verifier.
     * @throws \Abraham\TwitterOAuth\TwitterOAuthException When the request fails.
     * @return string[] Access token.
     */
    protected function getAccessToken(string $oauthToken, string $oauthTokenSecret, string $oauthVerifier): array
    {
        $connection = $this->getConnection();
        $connection->setOauthToken($oauthToken, $oauthTokenSecret);

        return $connection->oauth("oauth/access_token", ["oauth_verifier" => $oauthVerifier]);
    }

    /**
     * Create an instance of {@link \Qobo\Social\Model\Entity\Account} with
     * twitter credentials.
     *
     * @param string[] $accessToken Twitter access token.
     * @throws \RuntimeException When twitter is not defined in networks table.
     * @return \Qobo\Social\Model\Entity\Account Account object.
     */
    protected function registerAccount(array $accessToken): Account
    {
        $entity = $this->getEntity($accessToken['screen_name']);
        $data = [
            'handle' => $accessToken['screen_name'],
            'is_ours' => true,
            'credentials' => json_encode($accessToken),
            'network_id' => $this->network->id,
        ];
        $accounts = TableRegistry::getTableLocator()->get('Qobo/Social.Accounts');
        $entity = $accounts->patchEntity($entity, $data, [
            'accessibleFields' => [
                'credentials' => true,
            ],
        ]);

        return $entity;
    }

    /**
     * Creates a new account, or returns an existing one.
     *
     * @param string $handle Account handle.
     * @return \Qobo\Social\Model\Entity\Account Account object.
     */
    protected function getEntity(string $handle): Account
    {
        // Check whether account already exists
        $accounts = TableRegistry::getTableLocator()->get('Qobo/Social.Accounts');
        $existingAccount = $accounts->query()->where(['handle' => $handle])->matching('Networks', function ($q) {
            return $q->where(['Networks.name' => self::NETWORK_NAME]);
        });

        if ($existingAccount->count() > 0) {
            return $existingAccount->first();
        }

        return $accounts->newEntity();
    }
}
