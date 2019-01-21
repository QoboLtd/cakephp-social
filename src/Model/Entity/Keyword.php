<?php
namespace Qobo\Social\Model\Entity;

use Cake\ORM\Entity;

/**
 * Keyword Entity
 *
 * @property string $id
 * @property string $name
 * @property string $type
 * @property string $topic_id
 * @property string $priority
 * @property \Cake\I18n\FrozenTime|null $trashed
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \Qobo\Social\Model\Entity\Topic $topic
 */
class Keyword extends Entity
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
