<?php

namespace Skeleton\Model\Entity;

use Cake\ORM\Entity;

/**
 * OauthAccessTokensOauthScope Entity
 *
 * @property string $oauth_access_token_id
 * @property string $oauth_scope_id
 *
 * @property \Skeleton\Model\Entity\OauthAccessToken $oauth_access_token
 * @property \Skeleton\Model\Entity\OauthScope $oauth_scope
 */
class OauthAccessTokensOauthScope extends Entity
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
        'oauth_access_token' => true,
        'oauth_scope' => true
    ];
}
