<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 18.11.2018
 * Time: 4:57
 */

namespace Service;

use Core\HTTP\Session;
use Exception\SecurityException;
use Model\UserModel;

class SecurityService
{
    /**
     * @var UserModel
     */
    private $model;

    /**
     * @param UserModel $model
     */
    public function __construct(UserModel $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $credentials
     * @throws SecurityException
     */
    public function authorize(array $credentials)
    {
        $user = $this->model->findByLogin($credentials['login']);
        if (!$user) {
            throw new SecurityException('User not found');
        }

        Session::getInstance()->set('user', $user);
    }

    /**
     * @return bool
     */
    public function isAuthorized(): bool
    {
        return Session::getInstance()->isset('user');
    }
}
