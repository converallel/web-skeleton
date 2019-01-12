<?php

namespace Skeleton;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Skeleton\Middleware\AuthenticationMiddleware;
use Skeleton\Middleware\LoggingMiddleware;

/**
 * Plugin for Skeleton
 */
class Plugin extends BasePlugin
{
    /**
     * Add middleware for the plugin.
     *
     * @param \Cake\Http\MiddlewareQueue $middleware The middleware queue to update.
     * @return \Cake\Http\MiddlewareQueue
     */
    public function middleware($middleware)
    {
        $middleware->prepend(new LoggingMiddleware());
        $middleware->prepend(new AuthenticationMiddleware());
        return $middleware;
    }

    public function bootstrap(PluginApplicationInterface $app)
    {
        $app->addPlugin('Cake/ElasticSearch', ['bootstrap' => true]);
        $app->addPlugin('Migrations');
        parent::bootstrap($app);
    }
}
