<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 11:32
 */

namespace Core\Form;

use Core\Form\Fields\AbstractField;

class FormBuilder
{
    /**
     * @var AbstractField[]
     */
    private $fields = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param string $name
     * @param string $type
     * @param array $options
     */
    public function add(string $name, string $type, array $options = [])
    {
        if (array_key_exists($name, $this->fields)) {
            throw new \LogicException(sprintf("Field %s has configured", $name));
        }
        if (!array_key_exists('data', $options) && $this->data && array_key_exists($name, $this->data)) {
            $options['data'] = $this->data[$name];
        }
        $this->fields[] = new $type($name, $options);
    }

    /**
     * @return Form
     */
    public function getForm(): Form
    {
        if (!$this->fields) {
            throw new \LogicException('There are no fields configured');
        }

        return new Form($this->fields, $this->data);
    }

    /**
     * @param array|null $data
     */
    public function setData(array $data = null)
    {
        if ($this->fields) {
            throw new \LogicException('Form building has started');
        }
        $this->data = $data ?: [];
    }
}
