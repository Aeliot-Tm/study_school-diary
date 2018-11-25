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
use Template\Menu;

/**
 * Class DefaultController
 */
class DefaultController
{
    /**
     * @var Menu
     */
    private $menu;

    /**
     * @param Menu $menu
     */
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * @return RedirectResponse
     * @throws \Exception
     */
    public function index()
    {
        $items = $this->menu->getItems();
        if ($items) {
            $first = reset($items);

            return new RedirectResponse($first['url'], Response::REDIRECT_FOUND);
        }

        throw new \Exception('User menu has not configured yet');
    }
}
