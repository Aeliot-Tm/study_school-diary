<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 07.11.2018
 * Time: 13:07
 */

namespace Core;


class Autoloader
{
    private $dirs = [];

    /**
     * Autoloader constructor.
     * @param array $dirs
     */
    public function __construct(array $dirs)
    {
        $this->dirs = $dirs;
    }

    /**
     * @param string $class
     * @return void
     */
    public function load(string $class)
    {
        $subPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        foreach ($this->dirs as $dir) {
            $path = "$dir/$subPath.php";
            if (file_exists($path)) {
                include $path;
                break;
            }
        }
    }
}
