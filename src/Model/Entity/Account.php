<?php
namespace Qobo\Social\Model\Entity;

use Cake\Core\Configure;
use Cake\ORM\Entity;
use Cake\Utility\Security;
use RuntimeException;

/**
 * Account Entity
 *
 * @property string $id
 * @property string $network_id
 * @property string|null $handle
 * @property bool|null $active
 * @property bool|null $is_ours
 * @property string|null $credentials
 * @property \Cake\I18n\FrozenTime|null $trashed
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \Qobo\Social\Model\Entity\Network $network
 * @property \Qobo\Social\Model\Entity\Post[] $posts
 */
class Account extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'credentials' => false,
    ];

    /**
     * Returns the decrypted credentials.
     *
     * @return string|null Credentials or null when empty.
     */
    public function decryptCredentials(): ?string
    {
        $salt = Configure::readOrFail('Qobo/Social.encrypt.credentials.encryptionKey');
        $credentials = $this->get('credentials');
        if (!empty($credentials)) {
            $decoded = base64_decode($credentials);
            $decrypted = Security::decrypt($decoded, $salt);
            if ($decrypted === false) {
                throw new RuntimeException('Unable to decypher credentials. Check your enryption key.');
            }

            return $decrypted;
        }

        return null;
    }
}
