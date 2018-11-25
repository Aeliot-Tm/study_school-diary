<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 24.11.2018
 * Time: 23:44
 */

namespace Core\Security;

use Core\HTTP\Request\Request;
use Core\HTTP\Request\Route;
use Core\HTTP\Response\RedirectResponse;

interface MiddlewareInterface
{
    /**
     * @param Route $route
     * @param Request $request
     * @return RedirectResponse|null
     */
    public function handle(Route $route, Request $request);
}
