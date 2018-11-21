<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 17.11.2018
 * Time: 12:00
 */

namespace Controller;

use Core\HTTP\Response\RedirectResponse;
use Core\HTTP\Response\Response;

/**
 * Class DefaultController
 */
class DefaultController
{
    public function index()
    {
        return new RedirectResponse('/users', Response::REDIRECT_FOUND);
    }
}