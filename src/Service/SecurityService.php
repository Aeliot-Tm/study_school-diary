<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 18.11.2018
 * Time: 4:57
 */

namespace Service;

use Core\DB\Exception\ExecutionException;
use Core\DB\Exception\NotUniqueException;
use Core\HTTP\Session;
use Core\Security\PasswordHelper;
use Model\UserModel;

class SecurityService
{
    /**
     * @var UserModel
     */
    private $model;

    /**
     * @var PasswordHelper
     */
    private $passwordHelper;

    /**
     * @var Session
     */
    private $session;

    /**
     * @param Session $session
     * @param PasswordHelper $passwordHelper
     * @param UserModel $model
     */
    public function __construct(Session $session, PasswordHelper $passwordHelper, UserModel $model)
    {
        $this->model = $model;
        $this->passwordHelper = $passwordHelper;
        $this->session = $session;
    }

    /**
     * @param array $credentials
     * @return bool
     * @throws ExecutionException
     * @throws NotUniqueException
     * @throws \LogicException
     */
    public function authorize(array $credentials): bool
    {
        $user = $this->model->findByLogin($credentials['login']);
        if (!$user) {
            return false;
        }

        $salt = $this->passwordHelper->getSalt($user['password']);
        $securedPassword = $this->passwordHelper->getPassword($user['password']);
        if ($this->passwordHelper->getHash($credentials['password'], $salt) !== $securedPassword) {
            return false;
        }

        $this->session->set('user', $user);

        return true;
    }

    /**
     * @return bool
     */
    public function isAuthorized(): bool
    {
        return $this->session->isset('user');
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        if ($this->isAuthorized()) {
            $user = $this->session->get('user', []);

            return $user['roles'];
        }

        return [];
    }

    /**
     * @return void
     */
    public function logout()
    {
        $this->session->unset('user');
    }
}
