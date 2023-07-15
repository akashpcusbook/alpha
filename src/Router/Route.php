<?php

namespace Tusker\Framework\Router;

class Route
{
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_PUT = 'PUT';
    const HTTP_DELETE = 'DELETE';
    const HTTP_PATCH= 'PATCH';

    /**
     * store routes
     *
     * @var array<mixed, mixed>
     */
    private static array $routes = [];

    /**
     * register web routes
     *
     * @param string $request
     * @param string $uri
     * @param string $class
     * @param string $function
     * @param string $name
     * @return void
     */
    public static function web(string $request, string $uri, string $class, string $function, string $name = '', bool $isAuth = false): void
    {
        self::$routes['web'][] = self::createRouteInfo('web', $request, $uri, $class, $function, $name, $isAuth);
    }

    /**
     * register api routes
     *
     * @param string $request
     * @param string $uri
     * @param string $class
     * @param string $function
     * @param string $name
     * @return void
     */
    public static function api(string $request, string $uri, string $class, string $function, string $name = '', bool $isAuth = false): void
    {
        self::$routes['api'][] = self::createRouteInfo('api', $request, $uri, $class, $function, $name, $isAuth);
    }

    /**
     * get routes by type
     *
     * @param string $type
     * @return array<mixed, mixed>
     */
    public function getRoutes(string $type): array
    {
        return self::$routes[$type] ?? [];
    }

    /**
     * returns route info array
     *
     * @param string $type
     * @param string $request
     * @param string $uri
     * @param string $class
     * @param string $function
     * @param string $name
     * @return array<mixed, mixed>
     */
    private static function createRouteInfo(string $type, string $request, string $uri, string $class, string $function, string $name = '', bool $isAuth = false): array
    {
        $uri = ltrim($uri, '/');
        $uriParts = explode('/', $uri);

        $route = [
            'request' => $request,
            'uri' => ('api' === $type) ? 'api/'. $uri : (empty($uri) ? '/' : $uri),
            'match' => self::createRouteRegexByUri($uri),
            'class' => $class,
            'function' => $function,
            'name' => $name,
            'isAuth' => $isAuth,
            'params' => []
        ];

        $params = preg_grep('/{.*?\}/', $uriParts);
        foreach ($params as $key => $param)
        {
            $val = [
                'name' => str_replace(['{', '}'], '', $param),
                'uriPartPosition' => $key
            ];
            array_push($route['params'], $val);
        }

        return $route;
    }

    public static function createRouteRegexByUri(string $uri): string
    {
        $uri = ltrim($uri, '/');
        $uriParts = explode('/', $uri);
        $regex = [];

        foreach ($uriParts as $part) {
            $part = preg_match('/{.*?\}/', $part) ? '(.*)': $part;
            array_push($regex, $part);
        }

        return '/'.implode('\/', $regex).'/';
    }
}
