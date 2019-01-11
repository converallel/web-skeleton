<?php

namespace Skeleton\Model\Entity;

use Cake\ORM\Entity;

/**
 * SearchHistory Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $query
 * @property \Cake\I18n\FrozenTime $searched_at
 *
 * @property \Skeleton\Model\Entity\User $user
 */
class SearchHistory extends Entity
{
    use AuthorizationTrait;

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
        'user_id' => true,
        'type' => true,
        'query' => true
    ];
}
