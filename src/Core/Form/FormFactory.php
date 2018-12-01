<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 11:19
 */

namespace Core\Form;


use Core\Constraints\CallbackConstraint;
use Core\Form\Fields\HiddenType;
use Core\Violation\ViolationList;

class FormFactory
{
    /**
     * @var CSRFHelper
     */
    private $csrfHelper;

    /**
     * @param CSRFHelper $csrfHelper
     */
    public function __construct(CSRFHelper $csrfHelper)
    {
        $this->csrfHelper = $csrfHelper;
    }

    /**
     * @param string $formClass
     * @param mixed $data Default form data
     * @param array $options
     * @param array $arguments
     * @return Form
     */
    public function build(string $formClass, $data = null, array $options = [], array $arguments = []): Form
    {
        /** @var FormTypeInterface $formType */
        $formType = new $formClass(...$arguments);
        $options = $formType->resolveOptions($options);
        $builder = $this->getBuilder();
        $builder->setData($data);
        $formType->buildForm($builder, $options);
        $this->addCSRFProtection($builder, $formType);

        return $builder->getForm();
    }

    /**
     * @return FormBuilder
     */
    private function getBuilder(): FormBuilder
    {
        return new FormBuilder();
    }

    /**
     * @param FormBuilder $builder
     * @param FormTypeInterface $formType
     */
    private function addCSRFProtection(FormBuilder $builder, FormTypeInterface $formType)
    {
        $formKey = $this->csrfHelper->getFormKey(get_class($formType));
        $builder->add(
            '__csrf',
            HiddenType::class,
            [
                'constraints' => [
                    new CallbackConstraint(
                        function ($token, ViolationList $list, string $name) use ($formKey) {
                            $isValid = $token && $this->csrfHelper->isValid($token, $formKey);
                            if (!$isValid) {
                                $list->add('Invalid CSRF token', $name);
                            }

                            return $isValid;
                        }
                    ),
                ],
                'data' => $this->csrfHelper->getToken($formKey),
            ]
        );
    }
}
