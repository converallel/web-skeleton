<?php

namespace Skeleton\Model\Entity;

use Cake\ORM\Entity;

/**
 * OauthClientsOauthScope Entity
 *
 * @property int $oauth_client_id
 * @property string $oauth_scope_id
 *
 * @property \Skeleton\Model\Entity\OauthClient $oauth_client
 * @property \Skeleton\Model\Entity\OauthScope $oauth_scope
 */
class OauthClientsOauthScope extends Entity
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
        'oauth_client' => true,
        'oauth_scope' => true
    ];
}
