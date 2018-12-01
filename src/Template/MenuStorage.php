<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 1:41
 */

namespace Template;

use Core\HTTP\Session;
use Core\HTTP\SessionProvider;

class MenuStorage
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @param SessionProvider $sessionProvider
     * @throws \Exception
     */
    public function __construct(SessionProvider $sessionProvider)
    {
        $this->session = $sessionProvider();
    }

    /**
     * @return array|null
     */
    public function getItems()
    {
        return $this->session->get('menu');
    }

    /**
     * @return bool
     */
    public function hasItems(): bool
    {
        return $this->session->has('menu');
    }

    /**
     * @param array $items
     */
    public function setItems(array $items)
    {
        $this->session->set('menu', $items);
    }

    /**
     * @return void
     */
    public function removeItems()
    {
        $this->session->remove('menu');
    }
}