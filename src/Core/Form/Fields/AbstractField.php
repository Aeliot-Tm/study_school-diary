<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 12:09
 */

namespace Core\Form\Fields;

use Core\Constraints\RequiredConstraint;
use Core\Constraints\ValidatorInterface;
use Core\Form\Form;
use Core\Violation\ViolationList;

abstract class AbstractField
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var Form
     */
    private $form;

    /**
     * @param string $name
     * @param array $options
     */
    public function __construct(string $name, array $options)
    {
        if (array_key_exists('constraints', $options) && !is_array($options['constraints'])) {
            throw new \InvalidArgumentException('Invalid constraints option');
        }
        $this->name = $name;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->options['data'] ?? null;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->options['label'] ?? ucwords(implode(' ', explode('_', $this->getName())));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->renderLabel().$this->renderInput();
    }

    /**
     * @return string
     */
    abstract public function renderInput(): string;

    /**
     * @return string
     */
    public function renderLabel(): string
    {
        return sprintf('<label for="%s">%s</label>', $this->getId(), $this->getLabel());
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        if (is_string($data)) {
            $data = trim($data);
        }
        if ($data === '') {
            $data = null;
        }

        $this->options['data'] = $data;
    }

    /**
     * @param Form $form
     */
    public function setForm(Form $form)
    {
        $this->form = $form;
    }

    /**
     * @param ViolationList $list
     * @return bool
     */
    public function validate(ViolationList $list): bool
    {
        $countOnStart = $list->count();
        foreach ($this->getConstraints() as $constraint) {
            $constraint->validate($this->getData(), $list, $this->name, $this->form);
        }

        return $list->count() === $countOnStart;
    }

    /**
     * @return array
     */
    protected function getAttributes(): array
    {
        $attributes = $this->options['attr'] ?? [];
        $attributes['name'] = $this->getName();
        if ($this->isMultiple()) {
            $attributes['name'] .= '[]';
            $attributes['multiple'] = null;
        }
        if ($this->isRequired()) {
            $attributes['required'] = null;
        }
        $attributes['id'] = $this->getId();
        if (!array_key_exists('class', $attributes)) {
            $attributes['class'] = 'form-control';
        }

        return $attributes;
    }

    /**
     * @return ValidatorInterface[]
     */
    protected function getConstraints(): array
    {
        $constraints = $this->options['constraints'] ?? [];
        if ($this->isRequired()) {
            array_unshift($constraints, new RequiredConstraint());
        }

        return $constraints;
    }

    /**
     * @return bool
     */
    protected function isMultiple(): bool
    {
        return (bool)$this->options['multiple'] ?? false;
    }

    /**
     * @return bool
     */
    protected function isRequired(): bool
    {
        return (bool)$this->options['required'] ?? false;
    }

    /**
     * @return string
     */
    protected function renderAttributes(): string
    {
        $parts = [];
        foreach ($this->getAttributes() as $key => $value) {
            $parts[] = (null === $value) ? $key : sprintf('%s="%s"', $key, $value);
        }

        return implode(' ', $parts);
    }
}
