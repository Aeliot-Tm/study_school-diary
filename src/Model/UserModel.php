<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 1.11.18
 * Time: 17.53
 */

namespace Model;

use Core\DB\Connection;
use Core\DB\Query;
use Core\Security\StringBuilder;

class UserModel
{
    use ApplyFilterTrait;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * User constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param array $user
     * @throws \Exception
     */
    public function create(array $user)
    {
        $roles = $user['roles'];
        unset($user['roles']);

        $user = $this->updatePassword($user);
        $query = new Query();
        $query->insertInto('users');
        $fields = array_keys($user);
        $query->fields(...$fields);
        $item = array_map(
            function (string $key) {
                return ":$key";
            },
            $fields
        );
        $query->values($item);
        foreach ($user as $key => $value) {
            $query->setParameter($key, $value);
        }

        try {
            $this->connection->startTransaction();
            $this->connection->executeQuery($query);
            $id = $this->connection->getLastInsertId();

            $this->saveRoles($id, $roles);

            $this->connection->commit();
        } catch (\Exception $exception) {
            $this->connection->rollback();
            throw $exception;
        }
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $query = new Query();
        $query->delete()->from('users')->where('id = :id');
        $query->setParameter('id', $id);

        $this->connection->executeQuery($query);
    }

    /**
     * @param string $login
     * @return array|null
     */
    public function findByLogin(string $login)
    {
        $query = new Query();
        $query
            ->select('*')
            ->from('users')
            ->where('login = :login');
        $query->setParameter('login', $login);

        $user = $this->connection->fetchOneOrNull($query->getSQL(), $query->getParameters());
        if ($user) {
            $user['roles'] = $this->getUserRoles($user['id']);
        }

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function getList(int $limit, int $offset, array $filter): array
    {
        $query = new Query();
        $query
            ->select('*')
            ->from('users')
            ->limit($limit)
            ->offset($offset);
        $this->applyFilter($query, $filter);

        $users = $this->connection->fetchAll($query->getSQL(), $query->getParameters());
        foreach ($users as $index => $user) {
            $users[$index]['roles'] = $this->getUserRoles($user['id']);
        }

        return $users;
    }

    /**
     * @param array $roles
     * @return array
     */
    public function getNames(array $roles = []): array
    {
        $query = new Query();
        $query
            ->select('u.id', 'u.login')
            ->from('users', 'u');

        if ($roles) {
            $query->innerJoin('user_roles', 'ur', 'ur.user_id = u.id');
            $keys = [];
            foreach ($roles as $index => $role) {
                $roleKey = "role_$index";
                $query->setParameter($roleKey, $role);
                $keys[] = ":$roleKey";
            }
            $query->where(sprintf('ur.role IN (%s)', implode(',', $keys)));
            $query->groupBy('u.id');
        }

        $users = $this->connection->fetchAll($query->getSQL(), $query->getParameters());

        return array_combine(array_column($users, 'id'), array_column($users, 'login'));
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function getOne(int $id)
    {
        $query = new Query();
        $query
            ->select('*')
            ->from('users')
            ->where('id = :id');
        $query->setParameter('id', $id);

        $user = $this->connection->fetchOneOrNull($query->getSQL(), $query->getParameters());
        if ($user) {
            $user['roles'] = $this->getUserRoles($id);
        }

        return $user;
    }

    /**
     * @param array $user
     * @throws \Exception
     */
    public function update(array $user)
    {
        $id = $user['id'];
        $roles = $user['roles'];
        unset($user['id'], $user['roles']);

        $user = $this->updatePassword($user);
        $query = new Query();
        $query->update('users');
        foreach ($user as $key => $value) {
            $query->addSet($key, ":$key");
            $query->setParameter($key, $value);
        }
        $query->where('id = :id');
        $query->setParameter('id', $id);

        try {
            $this->connection->startTransaction();
            $this->connection->executeQuery($query);

            $this->saveRoles($id, $roles);

            $this->connection->commit();
        } catch (\Exception $exception) {
            $this->connection->rollback();
            throw $exception;
        }
    }

    /**
     * @param array $user
     * @return array
     */
    private function updatePassword(array $user): array
    {
        if (array_key_exists('plain_password', $user)) {
            if ($user['password'] && strpos($user['password'], ':')) {
                $parts = explode(':', $user['password']);
                $salt = array_shift($parts);
            } else {
                $salt = StringBuilder::buildString(5);
            }
            $hash = md5($salt.'|'.$user['plain_password']);
            $user['password'] = sprintf('%s:%s', $salt, $hash);
            unset($user['plain_password']);
        }

        return $user;
    }

    /**
     * @param int $id
     * @param array $roles
     */
    private function saveRoles(int $id, array $roles)
    {
        $queryDelete = new Query();
        $queryInsert = new Query();
        $queryInsert->insertInto('user_roles', 'IGNORE');
        $fields = ['user_id', 'role'];
        $queryInsert->fields(...$fields);
        $values = [];
        $roleKeysForDelete = [];
        foreach (array_values($roles) as $index => $role) {
            $userKey = "user_id_$index";
            $roleKey = "role_$index";
            $queryInsert->setParameter($userKey, $id);
            $queryInsert->setParameter($roleKey, $role);
            $queryDelete->setParameter($roleKey, $role);
            $values[] = [":$userKey", ":$roleKey"];
            $roleKeysForDelete[] = ":$roleKey";
        }
        $queryInsert->values(...$values);
        $this->connection->executeQuery($queryInsert);

        $queryDelete->delete()->from('user_roles')
            ->where('user_id = :user_id')
            ->andWhere(sprintf('role NOT IN (%s)', implode(',', $roleKeysForDelete)));
        $queryDelete->setParameter('user_id', $id);

        $this->connection->executeQuery($queryDelete);
    }

    /**
     * @param int $id
     * @return array
     */
    private function getUserRoles(int $id): array
    {
        $query = new Query();
        $query->select('role');
        $query->from('user_roles');
        $query->where('user_id = :user_id');
        $query->setParameter('user_id', $id);

        return $this->connection->fetchAll($query->getSQL(), $query->getParameters(), \PDO::FETCH_COLUMN);
    }
}
