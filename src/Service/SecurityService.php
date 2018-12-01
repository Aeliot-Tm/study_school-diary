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
use Core\HTTP\SessionProvider;
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
     * @param SessionProvider $sessionProvider
     * @param PasswordHelper $passwordHelper
     * @param UserModel $model
     * @throws \Exception
     */
    public function __construct(SessionProvider $sessionProvider, PasswordHelper $passwordHelper, UserModel $model)
    {
        $this->model = $model;
        $this->passwordHelper = $passwordHelper;
        $this->session = $sessionProvider();
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

        $salt = $this->passwordHelper->getSaltPart($user['password']);
        $hashPart = $this->passwordHelper->getHashPart($user['password']);
        $hash = $this->passwordHelper->getHash($credentials['password'], $salt);
        if ($hash !== $hashPart) {
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
        return $this->session->has('user');
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
        $this->session->remove('user');
    }
}
