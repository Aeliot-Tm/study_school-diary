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
     * @var MenuItem[]
     */
    private $menu;

    /**
     * @var SecurityService
     */
    private $securityService;

    /**
     * @param MenuItem[] $menu
     * @param SecurityService $securityService
     */
    public function __construct(array $menu, SecurityService $securityService)
    {
        $this->menu = $menu;
        $this->securityService = $securityService;
    }

    public function getItems()
    {
        //$roles =
        return $this->menu;
    }
}
