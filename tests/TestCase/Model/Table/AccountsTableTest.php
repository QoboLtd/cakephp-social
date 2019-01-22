<?php
namespace Qobo\Social\Test\TestCase\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;
use Qobo\Social\Model\Entity\Account;
use Qobo\Social\Model\Table\AccountsTable;
use Webmozart\Assert\Assert;

/**
 * Qobo\Social\Model\Table\AccountsTable Test Case
 */
class AccountsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Qobo\Social\Model\Table\AccountsTable
     */
    public $Accounts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.qobo/social.accounts',
        'plugin.qobo/social.networks',
        'plugin.qobo/social.posts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Accounts') ? [] : ['className' => AccountsTable::class];
        /** @var \Qobo\Social\Model\Table\AccountsTable $table */
        $table = TableRegistry::getTableLocator()->get('Accounts', $config);
        $this->Accounts = $table;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Accounts);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test encryption of credentials doesn't run when the account is not ours.
     *
     * @return void
     */
    public function testEncryptCredentialsIgnoreNotOurs(): void
    {
        $account = $this->Accounts->newEntity([
            'is_ours' => false,
            'handle' => 'test',
        ]);

        $actual = $this->Accounts->encryptCredentials($account);
        Assert::isInstanceOf($actual, Account::class);
        $this->assertSame($account, $actual);
        $this->assertFalse($actual->isDirty('credentials'));
    }

    /**
     * Test encryption of credentials when account is ours.
     *
     * @return void
     */
    public function testEncryptCredentialsIsOurs(): void
    {
        $credentials = 'foobar';
        $account = $this->Accounts->newEntity(
            [
                'is_ours' => true,
                'handle' => 'test',
                'credentials' => $credentials,
            ],
            [
                'accessibleFields' => [
                    'credentials' => true,
                ]
            ]
        );

        $actual = $this->Accounts->encryptCredentials($account);
        Assert::isInstanceOf($actual, Account::class);
        $this->assertSame($account, $actual);
        $this->assertTrue($actual->isDirty('credentials'));

        // Check decryption
        $key = (string)Configure::read('Qobo/Social.encrypt.credentials.encryptionKey');
        $encoded = (string)$actual->get('credentials');
        $encrypted = (string)base64_decode($encoded);
        $decrypted = Security::decrypt($encrypted, $key);
        $this->assertEquals($credentials, $decrypted);
    }
}
