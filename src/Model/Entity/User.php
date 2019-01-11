<?php

namespace Skeleton\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $phone_number
 * @property string $password
 * @property int $failed_login_attempts
 * @property string $given_name
 * @property string $family_name
 * @property \Cake\I18n\FrozenDate $birthdate
 * @property string $gender
 * @property int $location_id
 * @property int|null $profile_image_id
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime|null $deleted_at
 *
 * @property \Skeleton\Model\Entity\Location $location
 * @property \Skeleton\Model\Entity\Contact[] $contacts
 * @property \Skeleton\Model\Entity\Device[] $devices
 * @property \Skeleton\Model\Entity\File[] $files
 * @property \Skeleton\Model\Entity\Log[] $logs
 * @property \Skeleton\Model\Entity\SearchHistory[] $search_histories
 * @property \Skeleton\Model\Entity\UserLogin[] $user_logins
 */
class User extends Entity
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
        'email' => true,
        'phone_number' => true,
        'password' => true,
        'failed_login_attempts' => true,
        'given_name' => true,
        'family_name' => true,
        'birthdate' => true,
        'gender' => true,
        'location_id' => true,
        'profile_image_id' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
        '_joinData'
    ];

    protected function _getFullName()
    {
        return $this->given_name . ' ' . $this->family_name;
    }

    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher())->hash($password);
    }

    public function isViewableBy(User $user)
    {
        return true;
    }

    public function isCreatableBy($user)
    {
        return true;
    }

    public function isEditableBy(User $user)
    {
        return $this->id === $user->id;
    }

    public function isDeletableBy(User $user)
    {
        return $this->id === $user->id;
    }
}
