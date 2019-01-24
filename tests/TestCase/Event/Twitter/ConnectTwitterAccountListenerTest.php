<?php
namespace Qobo\Social\Test\TestCase\Event\Twitter;

use Cake\TestSuite\TestCase;

/**
 * Qobo\Social\Event\Twitter\ConnectTwitterAccountListenerTest Test Case
 */
class ConnectTwitterAccountListenerTest extends TestCase
{

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
}
