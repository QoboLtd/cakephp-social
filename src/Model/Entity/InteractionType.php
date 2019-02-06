<?php
namespace Qobo\Social\Model\Entity;

use Cake\ORM\Entity;

/**
 * InteractionType Entity
 *
 * @property string $id
 * @property string $network_id
 * @property string $slug
 * @property string $value_type
 * @property string|null $label
 *
 * @property \Qobo\Social\Model\Entity\Network $network
 */
class InteractionType extends Entity
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
    ];
}
