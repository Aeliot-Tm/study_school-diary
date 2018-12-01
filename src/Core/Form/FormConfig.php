<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 11:49
 */

namespace Core\Form;

use Core\Form\Fields\AbstractField;

class FormConfig
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var AbstractField
     */
    private $type;

    /**
     * @param string $name
     * @param AbstractField $type
     */
    public function __construct(string $name, AbstractField $type)
    {
        $this->type = $type;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return AbstractField
     */
    public function getType(): AbstractField
    {
        return $this->type;
    }
}