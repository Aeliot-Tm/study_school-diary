<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 01.12.2018
 * Time: 2:04
 */

namespace Core\Form\Fields;


abstract class AbstractInputField extends AbstractField
{
    protected $type;

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
        $options = array_merge_recursive($options, ['attr' => ['type' => $this->type]]);
        parent::__construct($name, $options);
    }

    /**
     * @return string
     */
    public function renderInput(): string
    {
        return sprintf('<input %s>', $this->renderAttributes());
    }

    /**
     * @return array
     */
    protected function getAttributes(): array
    {
        $attributes = ['value' => ''];
        if (null !== $this->getData()) {
            $attributes['value'] = $this->getData();
        }

        return array_merge(parent::getAttributes(), $attributes);
    }
}