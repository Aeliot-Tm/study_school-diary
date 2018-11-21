<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 1.11.18
 * Time: 17.54
 */

use Core\HTTP\Request\RequestBuilder;

require __DIR__.'/../app/autoload.php';

$request = RequestBuilder::getInstance();
$kernel = new AppKernel();
$response = $kernel->getResponse($request);
$response->send();
$kernel->terminate($request, $response);


