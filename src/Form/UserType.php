<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 07.11.2018
 * Time: 23:36
 */

namespace Form;

use Core\Constraints\ConfirmConstraint;
use Core\Form\Fields\ChoiceType;
use Core\Form\Fields\PasswordType;
use Core\Form\Fields\StringType;
use Core\Form\FormBuilder;
use Core\Form\FormTypeInterface;
use Enum\Role;

class UserType implements FormTypeInterface
{
    /**
     * @param FormBuilder $builder
     * @param array $parameters
     */
    public function buildForm(FormBuilder $builder, array $parameters)
    {
        $builder->add('login', StringType::class, ['required' => true]);
        $builder->add('plain_password', PasswordType::class, ['label' => 'Password']);
        $builder->add(
            'plain_password_confirm',
            PasswordType::class,
            ['label' => 'Confirm Password', 'constraints' => [new ConfirmConstraint('plain_password')]]
        );
        $builder->add(
            'roles',
            ChoiceType::class,
            [
                'choices' => array_combine(Role::getAll(), Role::getAll()),
                'multiple' => true,
                'required' => true,
            ]
        );
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
