<?php
namespace Qobo\Social\Test\TestCase\Provider\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Cake\TestSuite\TestCase;
use InvalidArgumentException;
use Qobo\Social\Provider\Twitter\AbstractTwitterPremiumProvider;

/**
 * Qobo\Social\Provider\Twitter\TwitterPremiumSearchProvider Test Case
 */
class AbstractTwitterPremiumProviderTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Social\Provider\Twitter\AbstractTwitterPremiumProvider
     */
    public $Provider;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->Provider = new class extends AbstractTwitterPremiumProvider {
            public function read(array $options = [])
            {
                return $this->searchTweets($this->parseOptions($options));
            }

            protected function callApi(string $archiveType, string $env, array $options)
            {
                return true;
            }
        };
        $this->Provider->setCredentials('foo', 'bar');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Provider);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testEnvironmentParameterMandatory(): void
    {
        $this->expectException(InvalidArgumentException::class);

        try {
            $this->Provider->read();
        } catch (InvalidArgumentException $e) {
            $this->assertContains('environment parameter is mandatory', $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInvalidArchiveType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $archiveType = 'invalid';
        $this->Provider->setConfig([
            'env' => 'dev',
            'archiveType' => $archiveType,
        ]);

        try {
            $this->Provider->read();
        } catch (InvalidArgumentException $e) {
            $this->assertContains("The archive type `{$archiveType}` is not valid", $e->getMessage());

            throw $e;
        }
    }

    /**
     * Test client getter
     *
     * @return void
     */
    public function testGetClient(): void
    {
        $client = $this->Provider->getClient();
        $this->assertInstanceOf(TwitterOAuth::class, $client);
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testRead(): void
    {
        $this->Provider->setConfig(['env' => 'dev']);
        $result = $this->Provider->read();
        $this->assertTrue($result);
    }
}
