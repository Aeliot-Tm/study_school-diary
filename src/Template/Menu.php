<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 1:55
 */

namespace Template;


class Menu
{
    /**
     * @var MenuBuilder
     */
    private $menuBuilder;

    /**
     * @var MenuStorage
     */
    private $menuStorage;

    /**
     * @param MenuBuilder $menuBuilder
     * @param MenuStorage $menuStorage
     */
    public function __construct(MenuBuilder $menuBuilder, MenuStorage $menuStorage)
    {
        $this->menuBuilder = $menuBuilder;
        $this->menuStorage = $menuStorage;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        if (!$this->menuStorage->hasItems()) {
            $this->menuStorage->setItems($this->menuBuilder->getItems());
        }

        return $this->menuStorage->getItems();
    }

    /**
     * @return void
     */
    public function invalidate()
    {
        $this->menuStorage->removeItems();
    }
}