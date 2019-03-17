<?php

namespace Skeleton\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Exception\BadRequestException;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Zend\Diactoros\Stream;

/**
 * OAuth Controller
 *
 * @property \League\OAuth2\Server\AuthorizationServer $OAuthServer
 * @property \Skeleton\Model\Table\OauthAccessTokensTable $AccessTokens
 * @property \Skeleton\Model\Table\OauthAuthorizationCodesTable $AuthorizationCodes
 * @property \Skeleton\Model\Table\OauthClientsTable $Clients
 * @property \Skeleton\Model\Table\OauthRefreshTokensTable $RefreshTokens
 * @property \Skeleton\Model\Table\OauthScopesTable $Scopes
 * @property \Skeleton\Model\Table\UsersTable $Users
 */
class OAuthController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadModel('OauthAccessTokens');
        $this->loadModel('OauthAuthorizationCodes');
        $this->loadModel('OauthClients');
        $this->loadModel('OauthRefreshTokens');
        $this->loadModel('OauthScopes');
        $this->loadModel('Users');

        $privateKey = CONFIG . 'oauth-private.key';
        $encryptionKey = Configure::read('Security.oauth.encryptionKey');

        $this->OAuthServer = new AuthorizationServer(
            $this->Clients,
            $this->AccessTokens,
            $this->Scopes,
            $privateKey,
            $encryptionKey
        );

        $grant_type = $this->getRequest()->getData('grant_type');

        switch ($grant_type) {
            case 'authorization_code':
                $grant = new \League\OAuth2\Server\Grant\AuthCodeGrant(
                    $this->AuthorizationCodes,
                    $this->RefreshTokens,
                    new \DateInterval('PT10M') // authorization codes will expire after 10 minutes
                );

                $grant->setRefreshTokenTTL(new \DateInterval('P1M')); // refresh tokens will expire after 1 month

                // Enable the authentication code grant on the server
                $this->OAuthServer->enableGrantType(
                    $grant,
                    new \DateInterval('PT1H') // access tokens will expire after 1 hour
                );
                break;
            case 'client_credentials':
                // Enable the client credentials grant on the server
                $this->OAuthServer->enableGrantType(
                    new \League\OAuth2\Server\Grant\ClientCredentialsGrant(),
                    new \DateInterval('PT1H') // access tokens will expire after 1 hour
                );
                break;
            case 'implicit':
                // Enable the implicit grant on the server
                $this->OAuthServer->enableGrantType(
                    new \League\OAuth2\Server\Grant\ImplicitGrant(new \DateInterval('PT1H')),
                    new \DateInterval('PT1H') // access tokens will expire after 1 hour
                );
                break;
            case 'password':
                $grant = new \League\OAuth2\Server\Grant\PasswordGrant($this->Users, $this->RefreshTokens);

                $grant->setRefreshTokenTTL(new \DateInterval('P1M')); // refresh tokens will expire after 1 month

                // Enable the password grant on the server
                $this->OAuthServer->enableGrantType(
                    $grant,
                    new \DateInterval('PT1H') // access tokens will expire after 1 hour
                );
                break;
            case 'refresh_token':
                $grant = new \League\OAuth2\Server\Grant\RefreshTokenGrant($this->RefreshTokens);
                $grant->setRefreshTokenTTL(new \DateInterval('P1M')); // new refresh tokens will expire after 1 month

                // Enable the refresh token grant on the server
                $this->OAuthServer->enableGrantType(
                    $grant,
                    new \DateInterval('PT1H') // new access tokens will expire after an hour
                );
                break;
            default:
                throw new BadRequestException("Unknown grant type: $grant_type");
        }

        // Add listeners
        $this->OAuthServer->getEmitter()->addListener(
            'clients.authentication.failed',
            function (\League\OAuth2\Server\RequestEvent $event) {
                // do something
            }
        );

        $this->OAuthServer->getEmitter()->addListener(
            'user.authentication.failed',
            function (\League\OAuth2\Server\RequestEvent $event) {
                $this->Users->recordFailedLoginAttempt($this->getRequest()->getData('username'));
            }
        );
    }

    public function oauth()
    {
        $this->redirect([
            'action' => 'authorize',
            '_ext' => $this->getRequest()->getParam('_ext'),
            '?' => $this->getRequest()->getQueryParams()
        ], 301);
    }

    public function authorize()
    {
        try {

            // Validate the HTTP request and return an AuthorizationRequest object.
            $authRequest = $this->OAuthServer->validateAuthorizationRequest($this->getRequest());

            // The auth request object can be serialized and saved into a user's session.
            // You will probably want to redirect the user at this point to a login endpoint.
//            $this->Users->

            // Once the user has logged in set the user on the AuthorizationRequest
            $authRequest->setUser(new UserEntity()); // an instance of UserEntityInterface

            // At this point you should redirect the user to an authorization page.
            // This form will ask the user to approve the client and the scopes requested.

            // Once the user has approved or denied the client update the status
            // (true = approved, false = denied)
            $authRequest->setAuthorizationApproved(true);

            // Return the HTTP redirect response
            return $this->OAuthServer->completeAuthorizationRequest($authRequest, $this->getResponse());

        } catch (OAuthServerException $exception) {

            // All instances of OAuthServerException can be formatted into a HTTP response
            return $exception->generateHttpResponse($this->getResponse());

        }
    }

    public function accessToken()
    {
        $data = $this->getRequest()->getData();

        if (!isset($data['grant_type'], $data['client_id'], $data['client_secret'])) {
            throw new BadRequestException();
        }

        if ($data['grant_type'] === 'password' && !isset($data['username'], $data['password'])) {
            throw new BadRequestException();
        }

        try {
            // Try to respond to the request
            return $this->OAuthServer->respondToAccessTokenRequest($this->getRequest(), $this->getResponse());

        } catch (OAuthServerException $exception) {

            // All instances of OAuthServerException can be formatted into a HTTP response
            return $exception->generateHttpResponse($this->getResponse());

        }
    }
}
