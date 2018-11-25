<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 24.11.2018
 * Time: 23:34
 */

namespace Middleware;

use Core\HTTP\Request\Request;
use Core\HTTP\Request\Route;
use Core\HTTP\Response\RedirectResponse;
use Core\Security\MiddlewareInterface;
use Service\SecurityService;

class GuestMiddleware implements MiddlewareInterface
{
    /**
     * @var SecurityService
     */
    private $securityService;

    /**
     * @param SecurityService $securityService
     */
    public function __construct(SecurityService $securityService)
    {
        $this->securityService = $securityService;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @return RedirectResponse|null
     */
    public function handle(Route $route, Request $request)
    {
        if (!$this->securityService->isAuthorized() && ($route->getPath() !== '/login')) {
            return new RedirectResponse('/login', RedirectResponse::REDIRECT_FOUND);
        }

        return null;
    }
}
