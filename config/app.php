<?php

use Cake\Core\Configure;

return [
    'Datasources' => [
        'elastic' => [
            'className' => 'Cake\ElasticSearch\Datasource\Connection',
            'driver' => 'Cake\ElasticSearch\Datasource\Connection',
            'host' => 'localhost',
            'port' => 9200,
        ],
    ],
    'OAuth2' => [
        'providers' => [
            'converallel' => [
                'className' => 'Converallel\OAuth2\Client\Provider\Converallel',
                // all options defined here are passed to the provider's constructor
                'options' => [
                    'clientId' => Configure::read('OAuth2.converallel.clientId'),
                    'clientSecret' => Configure::read('OAuth2.converallel.clientSecret'),
                ],
                'mapFields' => [
//                    'username' => 'login',
                ],
                // ... add here the usual AuthComponent configuration if needed like fields, etc.
            ],
        ],
    ]
];