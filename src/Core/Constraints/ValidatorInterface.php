<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 12:43
 */

namespace Core\Constraints;

use Core\Form\Form;
use Core\Violation\ViolationList;

interface ValidatorInterface
{
    /**
     * @param mixed $value
     * @param ViolationList $list
     * @param string $name
     * @param Form $form
     * @return bool
     */
    public function validate($value, ViolationList $list, string $name, Form $form): bool;
}
