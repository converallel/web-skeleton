<?php

namespace Skeleton\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use League\OAuth2\Server\Entities\UserEntityInterface;

/**
 * User Entity
 *
 * @property int $id
 * @property string|null $username
 * @property string $password
 * @property int $failed_login_attempts
 * @property string $given_name
 * @property string $family_name
 * @property \Cake\I18n\FrozenDate $birthdate
 * @property string $gender
 * @property int $location_id
 * @property int|null $profile_image_id
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 * @property \Cake\I18n\FrozenTime|null $deleted_at
 *
 * @property \Skeleton\Model\Entity\Location $location
 * @property \Skeleton\Model\Entity\File[] $files
 * @property \Skeleton\Model\Entity\Contact[] $contacts
 * @property \Skeleton\Model\Entity\Device[] $devices
 * @property \Skeleton\Model\Entity\Login[] $logins
 * @property \Skeleton\Model\Entity\Log[] $logs
 * @property \Skeleton\Model\Entity\OauthAccessToken[] $oauth_access_tokens
 * @property \Skeleton\Model\Entity\OauthAuthorizationCode[] $oauth_authorization_codes
 * @property \Skeleton\Model\Entity\OauthClient[] $oauth_clients
 * @property \Skeleton\Model\Entity\SearchHistory[] $search_histories
 */
class User extends Entity implements UserEntityInterface
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
        'username' => true,
        'password' => true,
        'failed_login_attempts' => true,
        'given_name' => true,
        'family_name' => true,
        'birthdate' => true,
        'gender' => true,
        'location_id' => true,
        'profile_image_id' => true,
        'files' => true,
        'contacts' => true,
        'devices' => true,
        'logins' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'deleted_at',
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

    /**
     * Return the user's identifier.
     *
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->id;
    }
}
