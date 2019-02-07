<?php
namespace Qobo\Social\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity
 *
 * @property string $id
 * @property string $account_id
 * @property string $external_post_id
 * @property string|null $post_id
 * @property string $type
 * @property string $url
 * @property string $subject
 * @property string|null $content
 * @property \Cake\I18n\FrozenTime|null $publish_date
 * @property string|null $extra
 * @property \Cake\I18n\FrozenTime|null $trashed
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \Qobo\Social\Model\Entity\Account $account
 * @property \Qobo\Social\Model\Entity\Post[] $posts
 * @property \Qobo\Social\Model\Entity\Topic[] $topics
 * @property \Qobo\Social\Model\Entity\PostInteraction[] $post_interactions
 */
class Post extends Entity
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
