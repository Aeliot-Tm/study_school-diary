<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 17.11.2018
 * Time: 15:12
 */

namespace Core\Security;


class StringBuilder
{
    /**
     * @param int $length
     * @return string
     */
    public static function buildString(int $length): string
    {
        $string = '';
        $stack = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $max = strlen($stack) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = rand(0, $max);
            $string .= $stack[$rand];
        }

        return $string;
    }
}
