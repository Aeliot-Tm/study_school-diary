<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 14:10
 */

namespace Core\HTTP\Request;

/**
 * Class Router
 */
class Router
{
    /**
     * @var array
     */
    private static $routes = [];

    /**
     * @param string $path
     * @param callable $callable
     * @param array $rules
     * @throws \LogicException
     */
    public static function add(string $path, callable $callable, array $rules = [])
    {
        if (preg_match('/[^a-z09_\/.{}-]/i', $path)) {
            throw new \InvalidArgumentException('Invalid URI pattern');
        }
        $route = new Route($path, $callable, $rules);
        if (array_key_exists($path, self::$routes)) {
            throw new \LogicException(sprintf('Invalid route has configured: %s', $path));
        }
        self::$routes[$path] = $route;
    }

    /**
     * @param string $path
     * @return Route|null
     */
    public static function find(string $path)
    {
        /** @var Route $route */
        foreach (self::$routes as $route) {
            if ($route->match($path)) {
                return $route;
            }
        }

        return null;
    }
}