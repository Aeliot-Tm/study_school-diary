<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 04.11.2018
 * Time: 0:13
 */

namespace Core;


interface StreamInterface
{
    /**
     * THINK is it acceptable to return all content of stream?
     * @return string
     */
    public function getContent(): string;
}