<?php

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\Event\EventManager;

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


/*
 * Modify `bake`
 */
EventManager::instance()->on('Bake.beforeRender.Controller.controller', function (Event $event) {
    $view = $event->getSubject();
    $name = $view->get('name');
    $theme = $view->getTheme();
    $override = class_exists("$theme\Controller\\{$name}Controller");

    $view->set(compact('override', 'theme'));
});

EventManager::instance()->on('Bake.beforeRender.Model.Entity', function (Event $event) {
    $view = $event->getSubject();
    $name = $view->get('name');
    $theme = $view->getTheme();
    $override = class_exists("$theme\Model\Entity\\{$name}");

    $view->set(compact('override', 'theme'));
});

EventManager::instance()->on('Bake.beforeRender.Model.Table', function (Event $event) {
    $view = $event->getSubject();
    $name = $view->get('name');
    $theme = $view->getTheme();
    $override = class_exists("\\$theme\Model\Table\\{$name}Table");

    $view->set(compact('override', 'theme'));
});