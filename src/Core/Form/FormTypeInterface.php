<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 11:24
 */

namespace Core\Form;

interface FormTypeInterface
{
    public function buildForm(FormBuilder $builder, array $parameters);

    public function resolveOptions(array $options): array;
}