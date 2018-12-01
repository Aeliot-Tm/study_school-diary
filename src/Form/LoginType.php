<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 07.11.2018
 * Time: 23:36
 */

namespace Form;

use Core\Form\Fields\PasswordType;
use Core\Form\Fields\StringType;
use Core\Form\FormBuilder;
use Core\Form\FormTypeInterface;

class LoginType implements FormTypeInterface
{
    /**
     * @param FormBuilder $builder
     * @param array $parameters
     */
    public function buildForm(FormBuilder $builder, array $parameters)
    {
        $builder->add('login', StringType::class, ['required' => true]);
        $builder->add('password', PasswordType::class, ['required' => true]);
    }

    /**
     * @param array $options
     * @return array
     */
    public function resolveOptions(array $options): array
    {
        return $options;
    }
}
