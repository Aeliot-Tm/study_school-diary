<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 18.11.2018
 * Time: 0:29
 */

namespace Template;

use Service\SecurityService;

class MenuBuilder
{
    /**
     * @var array
     */
    private $menu;

    /**
     * @var SecurityService
     */
    private $securityService;

    /**
     * @var array
     */
    private $routeSecurity;

    /**
     * @param array $menu
     * @param array $routeSecurity
     * @param SecurityService $securityService
     */
    public function __construct(array $menu, array $routeSecurity, SecurityService $securityService)
    {
        $this->menu = $menu;
        $this->securityService = $securityService;
        $this->routeSecurity = $routeSecurity;
    }

    public function getItems()
    {
        $roles = $this->securityService->getRoles();
        $items = [];
        foreach ($this->menu as $item) {
            $pathRoles = $this->getPathRoles($item['url']);
            if ((!$pathRoles && !$roles) || array_intersect($pathRoles, $roles)) {
                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * @param string $path
     * @return array|null
     */
    private function getPathRoles(string $path)
    {
        foreach ($this->routeSecurity as $pattern => $routeRoles) {
            if (preg_match(sprintf('#%s#', $pattern), $path)) {
                return $routeRoles;
            }
        }

        return [];
    }
}
