<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 1.11.18
 * Time: 17.55
 */

use Core\ServiceContainer;
use Core\DB\Connection;
use Core\HTTP\Exception\NotFoundException;
use Core\HTTP\Request\Request;
use Core\HTTP\Request\Route;
use Core\HTTP\Request\Router;
use Core\HTTP\Response\Response;

class AppKernel
{
    /**
     * @var ServiceContainer
     */
    private $container;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->container = ServiceContainer::getInstance(include __DIR__.'/config/config.php');
        $connection = $this->buildConnection();
        $this->container->set(get_class($connection), $connection);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws NotFoundException
     */
    public function getResponse(Request $request): Response
    {
        $this->loadRoutes();
        $route = $this->findRoute($request);
        $params = $this->buildActionParameters($route, $request);

        return call_user_func_array($this->getController($route), $params);
    }

    /**
     * @return Connection
     */
    private function buildConnection(): Connection
    {
        return new Connection($this->container->getParameter('database'));
    }

    /**
     * @param Route $route
     * @return callable
     */
    private function getController(Route $route): callable
    {
        $callable = $route->getCallable();
        if (is_array($callable) && (count($callable) === 2)) {
            $controller = reset($callable);
            if (is_string($controller)) {
                $controller = $this->container->get($controller);
                $callable = [$controller, array_values($callable)[1]];
            }
        }

        return $callable;
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function terminate(Request $request, Response $response)
    {
        exit();
    }

    /**
     * @param Route $route
     * @param Request $request
     * @return array
     */
    private function buildActionParameters(Route $route, Request $request): array
    {
        $params = $route->getPathValues($request->getPath());
        array_unshift($params, $request);

        return $params;
    }

    /**
     * @return void
     */
    private function loadRoutes()
    {
        require_once __DIR__.'/config/routes.php';
    }

    /**
     * @param Request $request
     * @return Route|null
     * @throws NotFoundException
     */
    private function findRoute(Request $request)
    {
        $route = Router::find($request->getPath());
        if ($route === null) {
            throw new NotFoundException();
        }

        return $route;
    }
}
