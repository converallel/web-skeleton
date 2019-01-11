<?php

return [
    'Datasources' => [
        'elastic' => [
            'className' => 'Cake\ElasticSearch\Datasource\Connection',
            'driver' => 'Cake\ElasticSearch\Datasource\Connection',
            'host' => 'localhost',
            'port' => 9200,
        ],
    ]
];