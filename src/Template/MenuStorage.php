<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 1:41
 */

namespace Template;

use Core\HTTP\Session;

class MenuStorage
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
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
        return $this->session->isset('menu');
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
        $this->session->unset('menu');
    }
}