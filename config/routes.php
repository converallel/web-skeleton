<?php

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;
use League\OAuth2\Server\ResourceServer;

Router::plugin('Skeleton', ['path' => '/'], function (RouteBuilder $routes) {

    // Register OAuth resource middleware
    $accessTokens = TableRegistry::getTableLocator()->get('Skeleton.OauthAccessTokens');
    $publicKeyPath = CONFIG . 'oauth-public.key';
    $resourceServer = new ResourceServer($accessTokens, $publicKeyPath);
    $routes->registerMiddleware('resource', new ResourceServerMiddleware($resourceServer));

    /**
     * Apply a middleware to the current route scope.
     * Requires middleware to be registered via `Application::routes()` with `registerMiddleware()`
     */
//    $routes->applyMiddleware('resource');

    $routes->resources('Contacts', ['only' => ['index', 'create', 'update', 'delete']]);

    $routes->resources('Files', ['only' => ['index', 'create', 'delete']]);

    $routes->resources('Locations', [
        'only' => ['view', 'create'],
        'actions' => ['view' => 'lookup'],
    ]);

    $routes->resources('Logs', ['only' => 'index']);

    $routes->resources('SearchHistories', ['only' => ['index', 'delete']]);

    $routes->resources('Search', ['only' => ['delete']]);

    $routes->get('/search/:type/:search_string', ['controller' => 'Search', 'action' => 'search'])
        ->setPass(['type', 'search_string'])->setPatterns(['type' => '[a-zA-Z]+', 'search_string' => '.{4,}']);

    //    $routes->resources('Settings');

    $routes->resources('Users', ['only' => ['view', 'update', 'delete']], function (RouteBuilder $routes) {
        $routes->resources('Locations', ['only' => ['update']]);
        $routes->resources('Files', ['only' => ['index']]);
    });

    $routes->connect('/signUp', ['controller' => 'users', 'action' => 'signUp'], ['_method' => ['GET', 'POST']]);

    $routes->connect('/login/:provider', ['controller' => 'users', 'action' => 'login'],
        [
            'provider' => implode('|', array_keys(Configure::read('OAuth2.providers'))),
            '_method' => ['GET', 'POST']
        ]
    );
});

Router::scope('/oauth', ['controller' => 'OAuth'], function (RouteBuilder $routes) {
    $routes->get('/', ['action' => 'oauth']);

    $routes->get('/authorize', ['action' => 'authorize']);

    $routes->post('/token', ['action' => 'accessToken']);
});