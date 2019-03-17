<?php

namespace Skeleton\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

class JWTAuthenticate extends BaseAuthenticate
{
    /**
     * Parsed token.
     *
     * @var string|null
     */
    protected $_token;

    /**
     * Payload data.
     *
     * @var array|null
     */
    protected $_payload;

    public function __construct(ComponentRegistry $registry, array $config = [])
    {
        $defaultConfig = [
            'allowedAlgs' => ['HS256'],
            'cookie' => false,
            'fields' => ['username' => 'id'],
            'header' => 'authorization',
            'key' => 'jwtKey',
            'prefix' => 'bearer',
            'queryParam' => 'token',
            'queryDatasource' => true,
            'unauthenticatedException' => UnauthorizedException::class,
        ];

        parent::__construct($registry, array_merge($defaultConfig, $config));
    }

    public function authenticate(ServerRequest $request, Response $response)
    {
        return $this->getUser($request);
    }

    public function unauthenticated(ServerRequest $request, Response $response)
    {
        $exception = new $this->_config['unauthenticatedException']($this->_registry->get('Auth')->getConfig('authError'));
        throw $exception;
    }

    public function getUser(ServerRequest $request)
    {
        $payload = $this->getPayload($request);
        if (!$payload)
            return false;

        $audience = $payload['aud'] ?? null;
        if (!$audience || $audience !== $_SERVER['HTTP_HOST'])
            return false;

        $config = $this->getConfig();
        if (!$config['queryDatasource'])
            return $payload;

        $subject = $payload['sub'] ?? null;
        if (!$subject)
            return false;

        $device_id = $payload['device_id'] ?? null;
        if (!$device_id)
            return false;

        return $this->_findUser($subject);
    }

    /**
     * Get payload data.
     *
     * @param \Cake\Http\ServerRequest|null $request Request instance or null
     * @return array|null Payload on success, null on failure.
     */
    public function getPayload($request = null)
    {
        if (!$request)
            return $this->_payload;

        if ($token = $this->getToken($request))
            $payload = $this->_decode($token);
        else
            $payload = null;

        return $this->_payload = $payload;
    }

    /**
     * Get token from header or cookie or query string.
     *
     * @param \Cake\Http\ServerRequest|null $request Request object.
     * @return string|null Token string if found else null.
     */
    public function getToken($request = null)
    {
        if ($request)
            return $this->_token;

        $config = $this->getConfig();
        $header = $request->getHeaderLine($config['header']);
        if ($header && stripos($header, $config['prefix']) === 0)
            $token = str_ireplace($config['prefix'] . ' ', '', $header);
        elseif ($cookie = $request->getCookie($config['cookie']))
            $token = (string)$cookie;
        elseif ($queryParam = $request->getQuery($config['queryParam']))
            $token = (string)$queryParam;
        else
            $token = null;

        return $this->_token = $token;
    }

    /**
     * Decode JWT token.
     *
     * @param string $token JWT token to decode.
     * @return array|null The JWT's payload, null on failure.
     */
    protected function _decode($token)
    {
        $config = $this->getConfig();
        $payload = JWT::decode($token,
            $config['key'] ? Configure::read("Security.{$config['key']}") : Security::getSalt(),
            $config['allowedAlgs']
        );

        return json_decode(json_encode($payload), true);
    }
}