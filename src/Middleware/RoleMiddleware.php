<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 24.11.2018
 * Time: 23:34
 */

namespace Middleware;

use Core\HTTP\Exception\UnauthorizedException;
use Core\HTTP\Request\Request;
use Core\HTTP\Request\Route;
use Core\Security\MiddlewareInterface;
use Service\SecurityService;

class RoleMiddleware implements MiddlewareInterface
{
    /**
     * @var SecurityService
     */
    private $securityService;

    /**
     * @var array
     */
    private $routeSecurity;

    /**
     * @param array $routeSecurity
     * @param SecurityService $securityService
     */
    public function __construct(array $routeSecurity, SecurityService $securityService)
    {
        $this->securityService = $securityService;
        $this->routeSecurity = $routeSecurity;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @return null
     * @throws UnauthorizedException
     */
    public function handle(Route $route, Request $request)
    {
        $roles = $this->securityService->getRoles();
        $isAuthenticated = $this->isAuthenticated($request->getPath(), $roles);
        if ($isAuthenticated === false) {
            throw new UnauthorizedException();
        }

        return null;
    }

    /**
     * @param string $path
     * @param array $roles
     * @return bool|null
     */
    private function isAuthenticated(string $path, array $roles)
    {
        foreach ($this->routeSecurity as $pattern => $routeRoles) {
            if (preg_match(sprintf('#%s#', $pattern), $path)) {
                return count(array_intersect($roles, $routeRoles)) > 0;
            }
        }

        return null;
    }
}
