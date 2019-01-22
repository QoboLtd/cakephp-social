<?php
namespace Qobo\Social\Model\Entity;

use Cake\ORM\Entity;

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
}
