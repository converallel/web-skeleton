<?php

namespace Skeleton\Model\Entity;

use Cake\ORM\Entity;

/**
 * OauthAuthorizationCodesOauthScope Entity
 *
 * @property string $oauth_authorization_code_id
 * @property string $oauth_scope_id
 *
 * @property \Skeleton\Model\Entity\OauthAuthorizationCode $oauth_authorization_code
 * @property \Skeleton\Model\Entity\OauthScope $oauth_scope
 */
class OauthAuthorizationCodesOauthScope extends Entity
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
        'oauth_authorization_code' => true,
        'oauth_scope' => true
    ];
}
