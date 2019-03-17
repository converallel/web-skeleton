<?php

namespace Skeleton\Model\Entity;

use Cake\ORM\Entity;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

/**
 * OauthScope Entity
 *
 * @property string $id
 * @property string $description
 *
 * @property \Skeleton\Model\Entity\OauthAccessToken[] $oauth_access_tokens
 * @property \Skeleton\Model\Entity\OauthAuthorizationCode[] $oauth_authorization_codes
 * @property \Skeleton\Model\Entity\OauthClient[] $oauth_clients
 */
class OauthScope extends Entity implements ScopeEntityInterface
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
        'description' => true,
        'oauth_access_tokens' => true,
        'oauth_authorization_codes' => true,
        'oauth_clients' => true
    ];

    protected $_hidden = [
        '_joinData'
    ];

    /**
     * Get the scope's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->id;
    }
}
