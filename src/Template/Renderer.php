<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 23:52
 */

namespace Template;

use Core\StreamInterface;

class Renderer
{
    /**
     * @var string
     */
    private $viewsDir;

    /**
     * @var MenuBuilder
     */
    private $menu;

    /**
     * @param string $viewsDir
     * @param Menu $menu
     */
    public function __construct(string $viewsDir, Menu $menu)
    {
        $this->viewsDir = $viewsDir;
        $this->menu = $menu;
    }

    /**
     * @param string $path
     * @param array $parameters
     * @return StreamInterface
     * @throws \Exception
     */
    public function render(string $path, array $parameters): StreamInterface
    {
        $parameters = array_merge(['menu' => $this->menu->getItems()], $parameters);

        return new TemplateStream($this->getRealPath($path), $parameters);
    }

    /**
     * @param string $path
     * @return string
     * @throws \Exception
     */
    private function getRealPath(string $path): string
    {
        $realPath = sprintf('%s/%s', $this->viewsDir, $path);
        if (!file_exists($realPath)) {
            throw new \Exception(sprintf('Invalid view path', $realPath));
        }

        return $realPath;
    }
}
