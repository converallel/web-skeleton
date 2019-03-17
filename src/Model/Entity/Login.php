<?php

namespace Skeleton\Model\Entity;

use Cake\ORM\Entity;

/**
 * Login Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $ip_address
 * @property int|null $device_id
 * @property string|null $browser
 * @property float|null $latitude
 * @property float|null $longitude
 * @property \Cake\I18n\FrozenTime $created_at
 *
 * @property \Skeleton\Model\Entity\User $user
 * @property \Skeleton\Model\Entity\Device $device
 */
class Login extends Entity
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
        'ip_address' => true,
        'device_id' => true,
        'browser' => true,
        'latitude' => true,
        'longitude' => true,
        'device' => true
    ];
}
