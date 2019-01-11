<?php

namespace Skeleton\Model\Entity;

use Cake\ORM\Entity;

/**
 * Location Entity
 *
 * @property int $id
 * @property float $latitude
 * @property float $longitude
 * @property string|null $name
 * @property string|null $iso_country_code
 * @property string|null $country
 * @property string|null $postal_code
 * @property string|null $administrative_area
 * @property string|null $sub_administrative_area
 * @property string|null $locality
 * @property string|null $sub_locality
 * @property string|null $thoroughfare
 * @property string|null $sub_thoroughfare
 * @property string|null $time_zone
 *
 * @property \Skeleton\Model\Entity\User[] $users
 */
class Location extends Entity
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
        'latitude' => true,
        'longitude' => true,
        'name' => true,
        'iso_country_code' => true,
        'country' => true,
        'postal_code' => true,
        'administrative_area' => true,
        'sub_administrative_area' => true,
        'locality' => true,
        'sub_locality' => true,
        'thoroughfare' => true,
        'sub_thoroughfare' => true,
        'time_zone' => true
    ];
}
