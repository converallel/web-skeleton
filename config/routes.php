<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('Skeleton', ['path' => '/'], function (RouteBuilder $routes) {
    $routes->resources('Contacts', ['only' => ['create', 'update', 'delete']]);

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

    $routes->resources('Users', ['only' => ['view', 'create', 'update', 'delete']], function (RouteBuilder $routes) {
        $routes->resources('Contacts', ['only' => ['index']]);
        $routes->resources('Locations', ['only' => ['update']]);
        $routes->resources('Files', ['only' => ['index']]);
    });
});
