<?php

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Server\ServerFactory;
use Hyperf\Utils\ApplicationContext;
use Psr\Http\Message\ServerRequestInterface;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;


if (!function_exists('container')) {
    /**
     * @return \Psr\Container\ContainerInterface
     */
    function container()
    {
        return ApplicationContext::getContainer();
    }
}


if (!function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param null $abstract
     * @param array $parameters
     * @return mixed|\Psr\Container\ContainerInterface
     */
    function app($abstract = null, array $parameters = [])
    {
        if (is_null($abstract)) {
            return ApplicationContext::getContainer();
        }
        return ApplicationContext::getContainer()->make($abstract, $parameters);
    }
}


/**
 * redis 客户端实例
 */
if (!function_exists('redis')) {
    function redis()
    {
        return container()->get(Redis::class);
    }
}

/**
 * server 实例 基于 swoole server
 */
if (!function_exists('server')) {
    function server()
    {
        return container()->get(ServerFactory::class)->getServer()->getServer();
    }
}

/**
 * websocket frame 实例
 */
if (!function_exists('frame')) {
    function frame()
    {
        return container()->get(Frame::class);
    }
}

/**
 * websocket 实例
 */
if (!function_exists('websocket')) {
    function websocket()
    {
        return container()->get(WebSocketServer::class);
    }
}

/**
 * 缓存实例 简单的缓存
 */
if (!function_exists('cache')) {
    function cache()
    {
        return container()->get(Psr\SimpleCache\CacheInterface::class);
    }
}

/**
 * 控制台日志
 */
if (!function_exists('stdLog')) {
    function stdLog()
    {
        return container()->get(StdoutLoggerInterface::class);
    }
}

if (!function_exists('logger')) {
    /**
     * 文件日志
     * @return \Psr\Log\LoggerInterface
     */
    function logger()
    {
        return container()->get(LoggerFactory::class)->make();
    }
}

/**
 *
 */
if (!function_exists('request')) {
    function request()
    {
        return container()->get(ServerRequestInterface::class);
    }
}

/**
 *
 */
if (!function_exists('response')) {
    function response()
    {
        return container()->get(ResponseInterface::class);
    }
}
