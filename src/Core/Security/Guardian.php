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

/**
 * @package Core\Security
 */
class Guardian implements MiddlewareInterface
{
    /**
     * @var MiddlewareInterface[]
     */
    private $sentinels;

    /**
     * @param MiddlewareInterface[] $sentinels
     */
    public function __construct(...$sentinels)
    {
        $this->sentinels = $sentinels;
    }

    /**
     * @inheritdoc
     */
    public function handle(Route $route, Request $request)
    {
        foreach ($this->sentinels as $sentinel) {
            if ($response = $sentinel->handle($route, $request)) {
                return $response;
            }
        }

        return null;
    }
}