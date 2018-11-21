<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 23:01
 */

namespace Core\HTTP\Exception;


abstract class RequestException extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     */
    public function __construct($message = null, $code = 400)
    {
        parent::__construct($message, $code);
    }
}