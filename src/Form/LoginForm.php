<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 07.11.2018
 * Time: 23:36
 */

namespace Form;

use Core\HTTP\Request\Request;

class LoginForm
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
        $login = $request->get('login');
        $this->data['login'] = $login ? trim($login) : null;
        $password = $request->get('password');
        $this->data['password'] = $password ? trim($password) : null;

        if (!$login) {
            $this->violations['login'] = 'Login is required';
        }
        if (!$password) {
            $this->violations['password'] = 'Password is required';
        }
    }
}
