<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 07.11.2018
 * Time: 23:41
 */

namespace Core;


class ErrorBag
{
    private $errors = [];

    /**
     * @param string $key
     * @param string $message
     */
    public function add(string $key, string $message)
    {
        $this->errors[] = new Error($key, $message);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->errors);
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->errors;
    }
}