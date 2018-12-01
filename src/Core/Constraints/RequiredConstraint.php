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

class RequiredConstraint implements ValidatorInterface
{
    /**
     * @inheritdoc
     */
    public function validate($value, ViolationList $list, string $name, Form $form): bool
    {
        if ($value === null) {
            $list->add(sprintf('Field %s is required', $name), $name);
        }

        return $value !== null;
    }
}
