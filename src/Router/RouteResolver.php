<?php

namespace Tusker\Framework\Router;

use ReflectionClass;
use Tusker\Framework\Auth\AuthInterface;
use Tusker\Framework\Exception\InvalidAuthenticationException;
use Tusker\Framework\Exception\RouteNotFoundException;
use Tusker\Framework\Request\Server;
use Tusker\Framework\Support\Csrf;

class RouteResolver
{
    public function __construct(private Route $route) {}

    /**
     * resolve routes at run time
     *
     * @return void
     */
    public function resolve()
    {
        $uri = ltrim(Server::get('REQUEST_URI'), '/');
        $uriParts = explode('/', $uri);
        $isApi = 'api' === substr($uri, 0, 3);
        $routeInfo = $isApi ? $this->getRouteInfo('api') : $this->getRouteInfo('web');

        if (!empty($routeInfo)) {
            if (!$this->authenticate($routeInfo['isAuth'], $isApi)) {
                throw new InvalidAuthenticationException('Invalid Authentication', 401);
            }
            $class = new ReflectionClass($routeInfo['class']);
            $objectManager = getObjectManager();
            $cls = $objectManager->get($routeInfo['class']);

            if (count($routeInfo['params']) > 0) {
                foreach($routeInfo['params'] as $param) {
                    $objectManager->addVariables($param['name'], $uriParts[(int) $param['uriPartPosition']]);
                }
            }

            if (null === $cls) {
                $objectManager->add($routeInfo['class']);
                $cls = $objectManager->get($routeInfo['class']);
            }

            $function = $class->getMethod($routeInfo['function']);
            $params = $objectManager->getDependency($function);

            $cls->{$routeInfo['function']}(...$params);
        }
    }

    /**
     * get routes by route type
     *
     * @param string $type
     * @return array<mixed, mixed>
     */
    private function getRouteInfo(string $type): array
    {
        $uri = ltrim(Server::get('REQUEST_URI'), '/');
        $routes = $this->route->getRoutes($type);
        if (empty($uri)) {
            $routes = array_filter($routes, function($item) {
                return '/' === $item['uri'];
            });
        } else {
            $routes = array_filter($routes, function($item) use ($uri) {
                if ('/' !== $item['uri']) {
                    return preg_match($item['match'], $uri);
                }
            });
        }
        if (count($routes) > 1) {
            $routes = array_filter($routes, function($item) use ($uri) {
                return $item['uri'] === $uri;
            });
        }
        if (0 === count($routes)) {
            throw new RouteNotFoundException('Route not found for:'. $uri);
        } else if ($routes[array_keys($routes)[0]]['request'] !== get_http_request_method()) {
            throw new RouteNotFoundException('Route not supported for:'. $routes[array_keys($routes)[0]]['request'] .' method');
        }

        return $routes[array_keys($routes)[0]];
    }

    private function authenticate(bool $isAuth, bool $isApi): bool
    {
        if ($isAuth) {
            $objectManager = getObjectManager();

            if(!$isApi) {
                /**
                 * @var Csrf $csrf
                 */
                $csrf = $objectManager->get(Csrf::class);

                return $csrf->validate();
                
            } else {
                /**
                 * @var AuthInterface $auth
                 */
                $auth = $objectManager->get(AuthInterface::class);

                return $auth->authenticate();
            }
        }

        return true;
    }
}
