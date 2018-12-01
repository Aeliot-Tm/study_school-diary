<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 12:31
 */

namespace Core\Violation;

class ViolationList implements \Iterator
{
    /**
     * @var Violation[]
     */
    private $violations = [];

    /**
     * @inheritdoc
     */
    public function current()
    {
        return current($this->violations);
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        return next($this->violations);
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return key($this->violations);
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return key($this->violations) !== null;
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        reset($this->violations);
    }

    /**
     * @param string $field
     * @param string $message
     */
    public function add(string $message, string $field)
    {
        $this->violations[] = new Violation($message, $field);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->violations);
    }
}
