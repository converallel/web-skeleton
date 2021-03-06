<?php

namespace Skeleton;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\SecurityHeadersMiddleware;
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
        $securityHeaders = new SecurityHeadersMiddleware();
        $securityHeaders
            ->setCrossDomainPolicy()
            ->setReferrerPolicy()
            ->setXFrameOptions()
            ->setXssProtection()
            ->noOpen()
            ->noSniff();

        $middleware->prepend($securityHeaders);
        $middleware->prepend(new LoggingMiddleware());
        $middleware->prepend(new BodyParserMiddleware(['xml' => true]));

        return $middleware;
    }

    public function bootstrap(PluginApplicationInterface $app)
    {
        $app->addPlugin('Cake/ElasticSearch', ['bootstrap' => true]);
        $app->addPlugin('Josegonzalez/Upload', ['bootstrap' => true]);
        $app->addPlugin('Migrations');
        parent::bootstrap($app);
    }
}
