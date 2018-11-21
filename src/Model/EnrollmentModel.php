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

class EnrollmentModel
{
    use ApplyFilterTrait;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param array $enrollment
     * @throws \Exception
     */
    public function create(array $enrollment)
    {
        $query = new Query();
        $query->insertInto('enrollments');
        $fields = array_keys($enrollment);
        $query->fields(...$fields);
        $item = array_map(
            function (string $key) {
                return ":$key";
            },
            $fields
        );
        $query->values($item);
        foreach ($enrollment as $key => $value) {
            $query->setParameter($key, $value);
        }

        $this->connection->executeQuery($query);
    }

    /**
     * @param int $id
     * @throws \Core\DB\Exception\ExecutionException
     */
    public function delete(int $id)
    {
        $query = new Query();
        $query->delete()->from('enrollments')->where('id = :id');
        $query->setParameter('id', $id);

        $this->connection->executeQuery($query);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param array $filter
     * @return array
     * @throws \Core\DB\Exception\ExecutionException
     */
    public function getList(int $limit, int $offset, array $filter): array
    {
        $query = new Query();
        $query
            ->select('e.*', 'u.login user_name', 's.name subject_name')
            ->from('enrollments', 'e')
            ->innerJoin('users', 'u', 'u.id=e.user_id')
            ->innerJoin('subjects', 's', 's.id=e.subject_id')
            ->limit($limit)
            ->offset($offset);
        $this->applyFilter($query, $filter);

        return $this->connection->fetchAll($query->getSQL(), $query->getParameters());
    }

    /**
     * @param int $id
     * @return array|null
     * @throws \Core\DB\Exception\ExecutionException
     * @throws \Core\DB\Exception\NotUniqueException
     */
    public function getOne(int $id)
    {
        $query = new Query();
        $query
            ->select('e.*', 'u.login user_name', 's.name subject_name')
            ->from('enrollments', 'e')
            ->innerJoin('users', 'u', 'u.id=e.user_id')
            ->innerJoin('subjects', 's', 's.id=e.subject_id')
            ->where('e.id = :id');
        $query->setParameter('id', $id);

        return $this->connection->fetchOneOrNull($query->getSQL(), $query->getParameters());
    }

    /**
     * @param array $enrollment
     * @throws \Exception
     */
    public function update(array $enrollment)
    {
        $id = $enrollment['id'];
        unset($enrollment['id'], $enrollment['user_name'], $enrollment['subject_name']);
        $query = new Query();
        $query->update('enrollments');
        foreach ($enrollment as $key => $value) {
            $query->addSet($key, ":$key");
            $query->setParameter($key, $value);
        }
        $query->where('id = :id');
        $query->setParameter('id', $id);

        $this->connection->executeQuery($query);
    }
}
