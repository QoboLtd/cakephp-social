<?php
namespace Qobo\Social\Model\Entity;

use Cake\ORM\Entity;

/**
 * PostInteraction Entity
 *
 * @property string $id
 * @property string $post_id
 * @property string $interaction_type_id
 * @property int $value_int
 * @property \Cake\I18n\FrozenTime $import_date
 *
 * @property \Qobo\Social\Model\Entity\Post $post
 * @property \Qobo\Social\Model\Entity\InteractionType $interaction_type
 */
class PostInteraction extends Entity
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
        'post_id' => true,
        'interaction_type_id' => true,
        'value_int' => true,
        'import_date' => true,
        'post' => true,
        'interaction_type' => true
    ];
}
