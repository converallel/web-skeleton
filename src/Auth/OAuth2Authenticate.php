<?php

namespace OAuth2\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Http\Exception\InternalErrorException;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use League\OAuth2\Client\Provider\AbstractProvider;


class OAuth2Authenticate extends BaseAuthenticate
{

    /**
     * Instance of OAuth2 provider.
     *
     * @var \League\OAuth2\Client\Provider\AbstractProvider
     */
    protected $_provider;


    public function __construct(ComponentRegistry $registry, array $config = [])
    {
        $config = $this->normalizeConfig($config);
        parent::__construct($registry, $config);
    }

    /**
     * Normalizes providers' configuration.
     *
     * @param array $config Array of config to normalize.
     * @return array
     */
    public function normalizeConfig(array $config)
    {
        $config = Hash::merge((array)Configure::read('OAuth2'), $config);

        if (empty($config['providers'])) {
            throw new InternalErrorException('No OAuth providers configured.');
        }

        array_walk($config['providers'], [$this, '_normalizeConfig'], $config);

        return $config;
    }

    /**
     * Callback to loop through config values.
     *
     * @param array $config Configuration.
     * @param string $alias Provider's alias (key) in configuration.
     * @param array $parent Parent configuration.
     * @return void
     */
    protected function _normalizeConfig(&$config, $alias, $parent)
    {
        unset($parent['providers']);

        $defaults = [
                'className' => null,
                'options' => [],
                'collaborators' => [],
                'mapFields' => [],
            ] + $parent + $this->_defaultConfig;

        $config = array_intersect_key($config, $defaults);
        $config += $defaults;

        array_walk($config, [$this, '_validateConfig']);

        foreach (['options', 'collaborators'] as $key) {
            if (empty($parent[$key]) || empty($config[$key])) {
                continue;
            }

            $config[$key] = array_merge($parent[$key], $config[$key]);
        }
    }

    /**
     * Validates the configuration.
     *
     * @param mixed $value Value.
     * @param string $key Key.
     * @return void
     */
    protected function _validateConfig(&$value, $key)
    {
        if ($key === 'className' && !class_exists($value)) {
            throw new InternalErrorException("Invalid provider or missing class $value");
        }

        if (!is_array($value) && in_array($key, ['options', 'collaborators'])) {
            throw new InternalErrorException("Invalid provider or missing class $key");
        }
    }

    public function authenticate(ServerRequest $request, Response $response)
    {
        return $this->getUser($request);
    }

    public function getUser(ServerRequest $request)
    {
        if (!$rawData = $this->_authenticate($request)) {
            return false;
        }

        $user = $this->_map($rawData);
        if (!$user || !$this->getConfig('userModel')) {
            return false;
        }

        if (!$result = $this->_touch($user)) {
            return false;
        }

        // TODO: Save token in db

        return $result;
    }

    /**
     * Authenticates with OAuth2 provider by getting an access token and
     * retrieving the authorized user's profile data.
     *
     * @param \Cake\Http\ServerRequest $request Request object.
     * @return array|bool
     */
    protected function _authenticate(ServerRequest $request)
    {
        if (list($grant_type, $options) = $this->_validate($request)) {
            return false;
        }

        $provider = $this->getProvider($request);

        try {
            // Try to get an access token using the resource owner password credentials grant.
            $accessToken = $provider->getAccessToken($grant_type, $options);
            $result = compact('accessToken') + $provider->getResourceOwner($accessToken)->toArray();

            return $result;
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            // Failed to get the access token
            $this->setConfig('authError', $e->getMessage());
            return false;
        }
    }

    /**
     * Finds or creates a local user.
     *
     * @param array $data Mapped user data.
     * @return array
     */
    protected function _touch(array $data)
    {
        if ($result = $this->_findUser($data[$this->getConfig('fields.username')])) {
            return array_merge($data, $result);
        }

        $users = TableRegistry::getTableLocator()->get('Users');
        $user = $users->newEntity($data);
        $users->save($user);

        return $user->toArray();
    }

    /**
     * Validates OAuth2 request.
     *
     * @param \Cake\Http\ServerRequest $request Request object.
     * @return array|bool grant_type and options on success, false on failure.
     */
    protected function _validate(ServerRequest $request)
    {
        $queryParams = $request->getQueryParams();

        $grant_type = null;
        $options = [];
        if (isset($queryParams['code'])) {
            $grant_type = 'authorization_code';
            $options += compact('code');
        }

        if (isset($queryParams['username'], $queryParams['password'])) {
            $grant_type = 'password';
            $options += compact('username', 'password');
        }

        if (!$grant_type || !$this->getProvider($request)) {
            return false;
        }

        $session = $request->getSession();
        $sessionKey = 'oauth2state';
        $state = $request->getQuery('state');

        if ($this->getConfig('options.state') && (!$state || $state !== $session->read($sessionKey))) {
            $session->delete($sessionKey);
            return false;
        }

        return array($grant_type, $options);
    }

    /**
     * Maps raw provider's user profile data to local user's data schema.
     *
     * @param array $data Raw user data.
     * @return array
     */
    protected function _map($data)
    {
        if (!$map = $this->getConfig('mapFields')) {
            return $data;
        }

        foreach ($map as $dst => $src) {
            $data[$dst] = Hash::get($data, $src);
            $data = Hash::remove($data, $src);
        }

        return $data;
    }

    /**
     * Handles unauthenticated access attempts. Will automatically forward to the
     * requested provider's authorization URL to let the user grant access to the
     * application.
     *
     * @param \Cake\Http\ServerRequest $request Request object.
     * @param \Cake\Http\Response $response Response object.
     * @return \Cake\Http\Response|null
     */
    public function unauthenticated(ServerRequest $request, Response $response)
    {
        $Exception = new UnauthorizedException();
        throw $Exception;
//        $provider = $this->getProvider($request);
//        if (empty($provider) || !empty($request->getQuery('code'))) {
//            return null;
//        }
//
//        if ($this->getConfig('options.state')) {
//            $request->getSession()->write('oauth2state', $provider->getState());
//        }
//
//        return $response->withLocation($provider->getAuthorizationUrl($this->_queryParams()));
    }

    /**
     * @param ServerRequest $request
     * @return \League\OAuth2\Client\Provider\AbstractProvider|false
     */
    protected function getProvider(ServerRequest $request)
    {
        if (!$alias = $request->getParam('provider')) {
            return false;
        }

        if (!empty($this->_provider)) {
            return $this->_provider;
        }

        if (!$config = $this->getConfig('providers.' . $alias)) {
            return false;
        }

        $this->setConfig($config, null, true);

        if (is_object($config) && $config instanceof AbstractProvider) {
            return $config;
        }

        $class = $config['className'];

        return new $class($config['options'], $config['collaborators']);
    }
}