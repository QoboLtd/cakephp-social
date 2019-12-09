<?php
namespace Qobo\Social\Provider\Twitter;

use Abraham\TwitterOAuth\TwitterOAuthException;
use Cake\ORM\TableRegistry;
use InvalidArgumentException;
use Qobo\Social\Model\Entity\Account;
use Qobo\Social\Provider\ProviderException;
use Qobo\Social\Provider\ResponseInterface;
use stdClass;

/**
 * Twitter user timeline provider class.
 */
class TwitterUserTimelineProvider extends AbstractTwitterProvider
{
    /**
     * {@inheritDoc}
     */
    public function read(array $options = []): ResponseInterface
    {
        $accountId = $options['accountId'] ?? null;
        if (empty($accountId)) {
            throw new InvalidArgumentException('`accountId` is a mandatory parameter.');
        }

        $account = $this->findAccount($accountId);
        $credentials = $this->getAccountCredentials($account);
        $options['userId'] = $credentials['userId'];
        $config = $this->parseOptions($options);

        $response = $this->callApi($credentials['oauthToken'], $credentials['oauthTokenSecret'], $config);
        $payload = new stdClass();
        $payload->results = $response;

        $response = new TwitterResponse();
        $response->setPayload($payload);
        $response->setNetwork($this->network);

        return $response;
    }

    /**
     * Find the account credentials.
     *
     * @param \Qobo\Social\Model\Entity\Account $account Account entity.
     * @return string[] Credentials.
     */
    protected function getAccountCredentials(Account $account): array
    {
        $credentials = json_decode($account->get('credentials'));
        if ($credentials === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Account is missing credentials');
        }
        $oauthToken = $credentials->oauth_token ?? null;
        $oauthTokenSecret = $credentials->oauth_token_secret ?? null;
        $userId = $credentials->user_id ?? null;

        if (empty($oauthToken) || empty($oauthTokenSecret) || empty($userId)) {
            throw new InvalidArgumentException('Invalid twitter credentials stored in database.');
        }

        return compact('oauthToken', 'oauthTokenSecret', 'userId');
    }

    /**
     * Locate the account record.
     *
     * @param string $accountId Account UUID
     * @return \Qobo\Social\Model\Entity\Account Account entity.
     */
    protected function findAccount(string $accountId): Account
    {
        $table = TableRegistry::getTableLocator()->get('Qobo/Social.Accounts');
        /** @var \Qobo\Social\Model\Entity\Account $account */
        $account = $table->get($accountId, ['finder' => 'decrypt']);

        return $account;
    }

    /**
     * Call api.
     *
     * @param string $oauthToken User Token.
     * @param string $oauthTokenSecret User Token Secret.
     * @param mixed[] $options Query params
     * @return mixed
     */
    protected function callApi(string $oauthToken, string $oauthTokenSecret, array $options)
    {
        // @codeCoverageIgnoreStart
        try {
            $client = $this->getClient();
            $client->setOauthToken($oauthToken, $oauthTokenSecret);

            return $client->get("statuses/user_timeline", $options);
        } catch (TwitterOAuthException $e) {
            throw new ProviderException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * Parses options for searching tweets.
     *
     * See valid options {@link https://developer.twitter.com/en/docs/tweets/timelines/api-reference/get-statuses-user_timeline.html}
     *
     * @param mixed[] $options Options.
     * @return mixed[] Formatted options array
     */
    protected function parseOptions(array $options = []): array
    {
        $mandatory = [
            'user_id' => '',
            'screen_name' => '',
            'count' => 200,
        ];
        $defaults = [
            'since_id' => '',
            'max_id' => '',
            'trim_user' => '',
            'exclude_replies' => '',
            'include_rts' => '',
        ];

        // Apply defaults
        $result = $options + $mandatory;
        $result = $result + $defaults;
        foreach ($defaults as $key => $value) {
            if (empty($result[$key])) {
                unset($result[$key]);
            }
        }

        return $result;
    }
}
