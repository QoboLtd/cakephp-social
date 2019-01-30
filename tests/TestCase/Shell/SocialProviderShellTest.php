<?php
namespace Qobo\Social\Test\TestCase\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\TestSuite\ConsoleIntegrationTestCase;
use Qobo\Social\Shell\SocialProviderShell;

/**
 * Qobo\Social\Shell\SocialProviderShell Test Case
 */
class SocialProviderShellTest extends ConsoleIntegrationTestCase
{

    /**
     * ConsoleIo mock
     *
     * @var \Cake\Console\ConsoleIo|\PHPUnit\Framework\MockObject\MockObject
     */
    public $io;

    /**
     * Output string
     *
     * @var string
     */
    public $output = '';

    /**
     * Test subject
     *
     * @var \Qobo\Social\Shell\SocialProviderShell
     */
    public $SocialProvider;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        /** @var \Cake\Console\ConsoleIo|\PHPUnit\Framework\MockObject\MockObject $mock */
        $mock = $this->getMockBuilder('Cake\Console\ConsoleIo')->getMock();
        $this->io = $mock;
        $this->SocialProvider = new SocialProviderShell($this->io);
        $this->SocialProvider->loadTasks();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SocialProvider);
        unset($this->io);
        unset($this->output);

        parent::tearDown();
    }

    /**
     * Test getOptionParser method
     *
     * @return void
     */
    public function testGetOptionParser(): void
    {
        $parser = $this->SocialProvider->getOptionParser();
        $this->assertInstanceOf(ConsoleOptionParser::class, $parser);
        $subcommands = $parser->subcommands();
        $this->assertArrayHasKey('import', $subcommands);
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testMain(): void
    {
        $this->io->expects($this->any())
            ->method('out')
            ->will($this->returnCallback([$this, 'setOutput']));

        $parser = $this->SocialProvider->getOptionParser();
        $expected = $parser->help();

        $actual = $this->SocialProvider->main();
        $this->assertEquals($expected, $this->output);
    }

    /**
     * Helper function to buffer the output
     *
     * @return bool Always true
     */
    public function setOutput(): bool
    {
        $args = func_get_args();
        list($message, $newlines, $level) = $args;
        $this->output = $message;

        return true;
    }
}
