<?php
namespace Qobo\Social\Model\Entity;

use Cake\ORM\Entity;

/**
 * PostsTopic Entity
 *
 * @property string $id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string $post_id
 * @property string $topic_id
 * @property \Cake\I18n\FrozenTime|null $trashed
 *
 * @property \Qobo\Social\Model\Entity\Post $post
 * @property \Qobo\Social\Model\Entity\Topic $topic
 */
class PostsTopic extends Entity
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
