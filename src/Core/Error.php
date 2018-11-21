<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 07.11.2018
 * Time: 23:44
 */

namespace Core;


class Error
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $message;

    /**
     * Error constructor.
     * @param string $key
     * @param string $message
     */
    public function __construct(string $key, string $message)
    {
        $this->key = $key;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}