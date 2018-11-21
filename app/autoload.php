<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 04.11.2018
 * Time: 11:26
 */

use Core\Autoloader;

include __DIR__.'/../src/Core/Autoloader.php';
$autoloader = new Autoloader([__DIR__.'/../src', __DIR__]);

spl_autoload_register([$autoloader, 'load']);
