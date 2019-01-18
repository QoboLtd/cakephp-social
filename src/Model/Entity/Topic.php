<?php
namespace Qobo\Social\Model\Entity;

use Cake\ORM\Entity;

/**
 * Topic Entity
 *
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property bool|null $active
 * @property \Cake\I18n\FrozenTime|null $trashed
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \Qobo\Social\Model\Entity\Keyword[] $keywords
 * @property \Qobo\Social\Model\Entity\Post[] $posts
 */
class Topic extends Entity
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
        'name' => true,
        'description' => true,
        'active' => true,
        'trashed' => true,
        'created' => true,
        'modified' => true,
        'keywords' => true,
        'posts' => true
    ];
}
