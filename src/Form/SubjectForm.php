<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 07.11.2018
 * Time: 23:36
 */

namespace Form;

use Core\HTTP\Request\Request;

class SubjectForm
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $violations = [];

    /**
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        $this->data = $data;
    }

    /**
     * @return array|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getViolations(): array
    {
        return $this->violations;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return !$this->violations;
    }

    /**
     * @param Request $request
     */
    public function parseRequest(Request $request)
    {
        $name = $request->get('name');
        $this->data['name'] = $name ? trim($name) : null;
        if (!$name) {
            $this->violations['name'] = 'Empty name';
        }
    }
}
