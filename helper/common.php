<?php

use Tusker\Framework\Bootstrap;
use Tusker\Framework\Manager\Object\ObjectManager;
use Tusker\Framework\Request\Server;
use Tusker\Framework\Support\Csrf;

/**
 * return app version
 *
 * @return string
 */
function app_version(): string
{
    return env('APP_VERSION', '1.0.0');
}

/**
 * return app version
 *
 * @return string
 */
function app_name(): string
{
    return env('APP_DOMAIN', 'localhost');
}

/**
 * get env vars
 *
 * @param string $key
 * @param string $default
 * @return string
 */
function env(string $key, string $default = ''): string
{
    return $_ENV[$key] ?? $default; 
}

/**
 * get object manager where all objects are stored and maintained
 *
 * @return ObjectManager
 */
function getObjectManager(): ObjectManager
{
    return ObjectManager::getInstance();
}

/**
 * returns app path
 *
 * @param string $path
 * @return string
 */
function app_path(string $path = ''): string
{
    return getcwd().'/'.$path;
}

/**
 * returns config directory path
 *
 * @return string
 */
function config_path(): string
{
    return app_path('config');
}

function get_http_request_method(): string
{
    return strtoupper(Server::get('REQUEST_METHOD'));
}

/**
 * returns header by key
 *
 * @param string $key
 * @return string|null
 */
function get_header(string $key): ?string
{
    $headers = getallheaders();

    return in_array($key, array_keys($headers)) ? $headers[$key] : null;
}

/**
 * return framewor bootstrap class
 *
 * @return Bootstrap
 */
function framework(): Bootstrap
{
    return new Bootstrap();
}

/**
 * load return sconfig files
 *
 * @param string $file
 * @return mixed
 */
function config(string $file)
{
    return require_once(config_path().'/'.$file.'.php');

}

/**
 * get csrf token
 *
 * @return string
 */
function csrf(): string
{
    /**
     * @var Csrf $csrf
     */
    $csrf = getObjectManager()->get(Csrf::class);
    $csrf->generate();

    return $csrf->getToken();
}

/**
 * convert text into base 64 url encode
 *
 * @param string $text
 * @return string
 */
function base64UrlEncode(string $text): string
{
    return str_replace(
        ['+', '/', '='],
        ['-', '_', ''],
        base64_encode($text)
    );
}


