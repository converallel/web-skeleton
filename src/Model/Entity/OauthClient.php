<?php

namespace Skeleton\Model\Entity;

use Cake\ORM\Entity;
use League\OAuth2\Server\Entities\ClientEntityInterface;

/**
 * OauthClient Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $secret
 * @property string $redirect_uri
 * @property string $grant_type
 * @property bool $revoked
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 *
 * @property \Skeleton\Model\Entity\User $user
 * @property \Skeleton\Model\Entity\OauthAccessToken[] $oauth_access_tokens
 * @property \Skeleton\Model\Entity\OauthAuthorizationCode[] $oauth_authorization_codes
 * @property \Skeleton\Model\Entity\OauthScope[] $oauth_scopes
 */
class OauthClient extends Entity implements ClientEntityInterface
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
        'name' => true,
        'secret' => true,
        'redirect_uri' => true,
        'grant_type' => true,
        'revoked' => true,
        'oauth_access_tokens' => true,
        'oauth_authorization_codes' => true,
        'oauth_scopes' => true
    ];

    /**
     * Get the client's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the client's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the registered redirect URI (as a string).
     *
     * Alternatively return an indexed array of redirect URIs.
     *
     * @return string|string[]
     */
    public function getRedirectUri()
    {
        return $this->redirect_uri;
    }
}
