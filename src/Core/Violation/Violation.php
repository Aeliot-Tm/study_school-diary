<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 12:30
 */

namespace Core\Violation;

/**
 * Class Violation
 */
class Violation
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $message;

    /**
     * @param string $message
     * @param string $field
     */
    public function __construct(string $message, string $field)
    {
        $this->field = $field;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
