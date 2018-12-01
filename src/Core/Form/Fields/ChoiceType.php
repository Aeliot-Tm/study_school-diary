<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 12:20
 */

namespace Core\Form\Fields;

use Core\Constraints\ChoiceConstraint;
use Core\Constraints\ValidatorInterface;

class ChoiceType extends AbstractField
{
    /**
     * @param string $name
     * @param array $options
     */
    public function __construct(string $name, array $options)
    {
        parent::__construct($name, $options);
        if (!array_key_exists('choices', $options) || !is_array($options['choices'])) {
            throw new \InvalidArgumentException('Invalid choices option');
        }
    }

    /**
     * @return string
     */
    public function renderInput(): string
    {
        $options = [];
        $multiple = $this->isMultiple();
        $data = $this->getData();
        foreach ($this->options['choices'] as $label => $value) {
            $selected = '';
            if ($multiple) {
                if ($data && is_array($data) && in_array($value, $data)) {
                    $selected = ' selected';
                }
            } elseif ($data === $value) {
                $selected = ' selected';
            }
            $options[] = sprintf('<option value="%s"%s>%s</option>', $value, $selected, $label);
        }

        return sprintf('<select %s>%s</select>', $this->renderAttributes(), implode('', $options));
    }

    /**
     * @return ValidatorInterface[]
     */
    protected function getConstraints(): array
    {
        $constraints = parent::getConstraints();
        $choices = array_unique(array_values($this->options['choices']));
        $constraints[] = new ChoiceConstraint($choices, $this->isMultiple());

        return $constraints;
    }
}
