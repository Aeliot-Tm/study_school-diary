<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 11:39
 */

namespace Core\Form;

use Core\Form\Fields\AbstractField;
use Core\HTTP\Request\Request;
use Core\Violation\ViolationList;

class Form
{
    /**
     * @var AbstractField[]
     */
    private $fields = [];

    /**
     * @var ViolationList
     */
    private $violationList;

    /**
     * @var bool
     */
    private $isParsed = false;

    /**
     * @var array
     */
    private $data;

    /**
     * @param AbstractField[] $fields
     * @param array $data
     */
    public function __construct(array $fields, array $data)
    {
        foreach ($fields as $field) {
            $field->setForm($this);
            $this->fields[$field->getName()] = $field;
        }
        $this->violationList = new ViolationList();
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        /** @var AbstractField $field */
        foreach ($this->fields as $field) {
            $name = $field->getName();
            if ('__csrf' !== $name && substr($name, -8) !== '_confirm') {
                $this->data[$name] = $field->getData();
            }
        }

        return $this->data;
    }

    /**
     * @return ViolationList
     */
    public function getErrors(): \Traversable
    {
        return $this->violationList;
    }

    /**
     * @param string $name
     * @return AbstractField
     * @throws \InvalidArgumentException
     */
    public function getField(string $name): AbstractField
    {
        if (!array_key_exists($name, $this->fields)) {
            throw new \InvalidArgumentException(sprintf('Undefined field %s', $name));
        }

        return $this->fields[$name];
    }

    /**
     * @return AbstractField[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        if (!$this->isParsed) {
            throw new \LogicException('Request has not parsed yet');
        }

        return $this->violationList->count() === 0;
    }

    /**
     * @param Request $request
     */
    public function parseRequest(Request $request)
    {
        if ($this->isParsed) {
            throw new \LogicException('Request has parsed already');
        }

        $this->isParsed = true;
        /** @var AbstractField $field */
        foreach ($this->fields as $field) {
            $name = $field->getName();
            $field->setData($request->get($name));
            $field->validate($this->violationList);
        }
    }
}
