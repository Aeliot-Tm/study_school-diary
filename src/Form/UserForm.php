<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 07.11.2018
 * Time: 23:36
 */

namespace Form;

use Core\HTTP\Request\Request;
use Enum\Role;

class UserForm
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
        $this->data = array_merge($this->getDefaults(), $data ?: []);
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
        $login = $request->get('login');
        $this->data['login'] = $login ? trim($login) : null;
        $password = $request->get('plain_password');
        $this->data['plain_password'] = $password ? trim($password) : null;
        $passwordConfirm = $request->get('plain_password_confirm');

        if (!$login) {
            $this->violations['login'] = 'Empty login';
        } else {
            $login = trim($login);
            if (!preg_match('/\\w+/i', $login)) {
                $this->violations['login'] = 'Login must be a word.';
            }
        }
        if ($password || $passwordConfirm) {
            $password = $this->data['plain_password'];
            $passwordConfirm = $passwordConfirm ? trim($passwordConfirm) : null;
            if (strlen($password) < 5) {
                $this->violations['plain_password'] = 'Password is too short';
            }
            if ($password !== $passwordConfirm) {
                $this->violations['plain_password_confirm'] = 'Password confirmation does not match password';
            }
        }

        $roles = array_filter((array)$request->get('roles', []));
        $this->data['roles'] = $roles;
        if ($roles) {
            $validRoles = array_intersect($roles, Role::getAll());
            if (count($validRoles) !== count($roles)) {
                $this->violations['roles'] = sprintf(
                    'Has invalid roles: %s.',
                    implode(', ', array_diff($roles, $validRoles))
                );
            }
        }
    }

    private function getDefaults(): array
    {
        return ['roles' => []];
    }
}
