<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 12:40
 */

namespace Core\Constraints;


use Core\Form\Form;
use Core\Violation\ViolationList;

class CallbackConstraint implements ValidatorInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @inheritdoc
     */
    public function validate($value, ViolationList $list, string $name, Form $form): bool
    {
        return call_user_func_array($this->callback, func_get_args());
    }
}
