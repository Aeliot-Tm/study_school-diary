<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 13:05
 */

namespace Core\Form\Fields;

class HiddenType extends AbstractInputField
{
    protected $type = 'hidden';

    /**
     * @return string
     */
    public function renderLabel(): string
    {
        return '';
    }
}