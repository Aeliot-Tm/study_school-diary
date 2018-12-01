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

class ConfirmConstraint implements ValidatorInterface
{
    /**
     * @var string
     */
    private $fieldToConfirm;

    /**
     * @param string $fieldToConfirm
     */
    public function __construct(string $fieldToConfirm)
    {
        $this->fieldToConfirm = $fieldToConfirm;
    }

    /**
     * @inheritdoc
     */
    public function validate($value, ViolationList $list, string $name, Form $form): bool
    {
        $confirmField = $form->getField($this->fieldToConfirm);
        $isValid = $confirmField->getData() === $value;
        if (!$isValid) {
            $list->add(
                sprintf(
                    'Value of %s is not the same as %s',
                    $form->getField($name)->getLabel(),
                    $confirmField->getLabel()
                ),
                $name
            );
        }

        return $isValid;
    }
}
