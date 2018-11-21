<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 23:13
 */

return [
    'parameters' => [
        'database' => require 'database.php',
        'views' => __DIR__.'/../views',
        'menu' => require 'menu.php',
    ],
    'services' => require 'services.php',
];