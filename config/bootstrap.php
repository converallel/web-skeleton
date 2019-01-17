<?php

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

/*
 * Add custom global functions.
 */
require 'functions.php';

/*
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::load('Skeleton.app', 'default', true);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

ConnectionManager::setConfig(Configure::consume('Datasources'));