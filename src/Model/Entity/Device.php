<?php

namespace Skeleton\Model\Entity;

use Cake\ORM\Entity;

/**
 * Device Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $uuid
 * @property string $name
 * @property \Cake\I18n\FrozenTime|null $deleted_at
 *
 * @property \Skeleton\Model\Entity\User $user
 * @property \Skeleton\Model\Entity\Login[] $logins
 */
class Device extends Entity
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
        'user_id' => true,
        'uuid' => true,
        'name' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'deleted_at'
    ];
}
