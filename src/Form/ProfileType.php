<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 07.11.2018
 * Time: 23:36
 */

namespace Form;

use Core\Form\Fields\StringType;
use Core\Form\FormBuilder;
use Core\Form\FormTypeInterface;

class ProfileType implements FormTypeInterface
{
    /**
     * @param FormBuilder $builder
     * @param array $parameters
     */
    public function buildForm(FormBuilder $builder, array $parameters)
    {
        $builder->add('login', StringType::class, ['required' => true]);
        $builder->add('plain_password', StringType::class, ['label' => 'Password']);
        $builder->add('plain_password_confirm', StringType::class, ['label' => 'Confirm Password']);
    }

    /**
     * @param array $options
     * @return array
     */
    public function resolveOptions(array $options): array
    {
        return array_merge_recursive(['_defaults' => ['roles' => []]], $options);
    }
}
