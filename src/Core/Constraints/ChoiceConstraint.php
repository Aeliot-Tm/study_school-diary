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

class ChoiceConstraint implements ValidatorInterface
{
    /**
     * @var array
     */
    private $choices;

    /**
     * @var bool
     */
    private $multiple;

    /**
     * @param array $choices
     * @param bool $multiple
     */
    public function __construct(array $choices, bool $multiple)
    {
        $this->choices = $choices;
        $this->multiple = $multiple;
    }

    /**
     * @inheritdoc
     */
    public function validate($value, ViolationList $list, string $name, Form $form): bool
    {
        if ($this->multiple && !is_array($value)) {
            $list->add('Value must be an array', $name);

            return false;
        }
        if ($value === null || $value === []) {
            return false;
        }
        $diff = array_diff((array)$value, array_values($this->choices));
        if ($diff) {
            $list->add('Has an invalid choice', $name);
        }

        return true;
    }
}
