<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 18.11.2018
 * Time: 0:29
 */

namespace Template;


class MenuItem
{
    /**
     * @var MenuItem[]
     */
    private $children = [];

    /**
     * @var array|null
     */
    private $expectedRoles = null;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var string|null
     */
    private $url;

    /**
     * MenuItem constructor.
     * @param string $name
     * @param string|null $url
     * @param array $roles
     */
    public function __construct(string $name, string $url = null, array $roles = [])
    {
        $this->name = $name;
        $this->url = $url;
        $this->roles = $roles;
    }

    /**
     * @param array|null $expectedRoles
     */
    public function setExpectedRoles(array $expectedRoles = null)
    {
        $this->expectedRoles = $expectedRoles;
    }

    /**
     * @param MenuItem $item
     */
    public function addChild(MenuItem $item)
    {
        $this->children[] = $item;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        /** @var MenuItem[] $children */
        $children = array_filter(
            $this->children,
            function (MenuItem $item) {
                return $this->expectedRoles ? array_intersect($item->roles, $this->expectedRoles) : !$item->roles;
            }
        );

        foreach ($children as $child) {
            $child->setExpectedRoles($this->expectedRoles);
        }

        return $children;
    }
}
