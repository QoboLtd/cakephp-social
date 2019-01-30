<?php
namespace Qobo\Social\Test\TestCase\Shell\Helper;

use Cake\Console\ConsoleIo;
use Cake\TestSuite\Stub\ConsoleOutput;
use Cake\TestSuite\TestCase;
use Qobo\Social\Shell\Helper\ArrayOptionsHelper;

/**
 * Qobo\Social\Shell\Helper\ArrayOptionsHelper Test Case
 */
class ArrayOptionsHelperTest extends TestCase
{

    /**
     * ConsoleOutput stub
     *
     * @var \Cake\TestSuite\Stub\ConsoleOutput
     */
    public $stub;

    /**
     * ConsoleIo mock
     *
     * @var \Cake\Console\ConsoleIo
     */
    public $io;

    /**
     * Test subject
     *
     * @var \Qobo\Social\Shell\Helper\ArrayOptionsHelper
     */
    public $ArrayOptions;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->stub = new ConsoleOutput();
        $this->io = new ConsoleIo($this->stub);
        $this->ArrayOptions = new ArrayOptionsHelper($this->io);
        $this->ArrayOptions->init([
            'params' => [
                'config' => [
                    'oof',
                    'foo=bar=baz',
                ],
            ],
        ]);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ArrayOptions);

        parent::tearDown();
    }

    /**
     * Test output method
     *
     * @return void
     */
    public function testOutput(): void
    {
        $this->ArrayOptions->output([]);
        $this->assertTrue(true);
    }

    /**
     * Test output method
     *
     * @return void
     */
    public function testGet(): void
    {
        $expected = [
            'oof',
            'foo' => 'bar=baz',
        ];
        $actual = $this->ArrayOptions->get('config');
        $this->assertEquals($expected, $actual);
    }
}
