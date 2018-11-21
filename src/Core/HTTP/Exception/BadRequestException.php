<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 23:01
 */

namespace Core\HTTP\Exception;


class BadRequestException extends RequestException
{
    /**
     * @param string|null $message
     */
    public function __construct($message = null)
    {
        parent::__construct($message ?: 'Bad request', 400);
    }
}