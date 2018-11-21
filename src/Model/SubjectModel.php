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

class SubjectModel
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
     * @param array $subject
     * @throws \Core\DB\Exception\ExecutionException
     */
    public function create(array $subject)
    {
        $query = new Query();
        $query->insertInto('subjects');
        $fields = array_keys($subject);
        $query->fields(...$fields);
        $item = array_map(
            function (string $key) {
                return ":$key";
            },
            $fields
        );
        $query->values($item);
        foreach ($subject as $key => $value) {
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
        $query->delete()->from('subjects')->where('id = :id');
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
            ->select('*')
            ->from('subjects')
            ->limit($limit)
            ->offset($offset);
        $this->applyFilter($query, $filter);

        return $this->connection->fetchAll($query->getSQL(), $query->getParameters());
    }

    /**
     * @return array
     * @throws \Core\DB\Exception\ExecutionException
     */
    public function getNames(): array
    {
        $query = new Query();
        $query
            ->select('id', 'name')
            ->from('subjects');
        $subjects = $this->connection->fetchAll($query->getSQL(), $query->getParameters());

        return array_combine(array_column($subjects, 'id'), array_column($subjects, 'name'));
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
            ->select('*')
            ->from('subjects')
            ->where('id = :id');
        $query->setParameter('id', $id);

        return $this->connection->fetchOneOrNull($query->getSQL(), $query->getParameters());
    }

    /**
     * @param array $subject
     * @throws \Exception
     */
    public function update(array $subject)
    {
        $id = $subject['id'];
        unset($subject['id']);
        $query = new Query();
        $query->update('subjects');
        foreach ($subject as $key => $value) {
            $query->addSet($key, ":$key");
            $query->setParameter($key, $value);
        }
        $query->where('id = :id');
        $query->setParameter('id', $id);

        $this->connection->executeQuery($query);
    }
}
