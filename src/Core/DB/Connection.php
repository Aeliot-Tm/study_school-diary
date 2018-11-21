<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 1.11.18
 * Time: 17.53
 */

namespace Core\DB;

use Core\DB\Exception\ExecutionException;
use Core\DB\Exception\NotUniqueException;

class Connection
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * Connection constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $args = $this->buildConnectionArguments($config);
        $this->connection = new \PDO(...$args);
    }

    /**
     * @throws ExecutionException
     */
    public function commit()
    {
        $statement = $this->connection->prepare('COMMIT;');
        if (!$statement->execute()) {
            throw new ExecutionException('Query cannot be executed');
        }
    }

    /**
     * @param Query $query
     * @throws ExecutionException
     */
    public function executeQuery(Query $query)
    {
        $statement = $this->prepare($query->getSQL());
        if (!$statement->execute($query->getParameters())) {
            throw new ExecutionException('Query cannot be executed');
        }
    }

    /**
     * @param string $sql
     * @param array|null $parameters
     * @param int|null $fetchStyle
     * @return array
     * @throws ExecutionException
     */
    public function fetch(string $sql, array $parameters = null, $fetchStyle = \PDO::FETCH_COLUMN): array
    {
        $statement = $this->prepare($sql);
        if (!$statement->execute($parameters)) {
            throw new ExecutionException('Query cannot be executed');
        }

        return $statement->fetch($fetchStyle);
    }

    /**
     * @param string $sql
     * @param array|null $parameters
     * @param int|null $fetchStyle
     * @return array
     * @throws ExecutionException
     */
    public function fetchAll(string $sql, array $parameters = null, int $fetchStyle = \PDO::FETCH_ASSOC): array
    {
        $statement = $this->prepare($sql);
        if (!$statement->execute($parameters)) {
            throw new ExecutionException('Query cannot be executed');
        }

        return $statement->fetchAll($fetchStyle);
    }

    /**
     * @param string $sql
     * @param array|null $parameters
     * @param int $fetchStyle
     * @return mixed|null
     * @throws ExecutionException
     * @throws NotUniqueException
     */
    public function fetchOneOrNull(string $sql, array $parameters = null, int $fetchStyle = \PDO::FETCH_ASSOC)
    {
        $statement = $this->prepare($sql);
        if (!$statement->execute($parameters)) {
            throw new ExecutionException('Query cannot be executed');
        }
        $items = $statement->fetchAll($fetchStyle);
        if (count($items) > 1) {
            throw new NotUniqueException();
        }

        return $items ? reset($items) : null;
    }

    /**
     * @return int|null
     * @throws ExecutionException
     */
    public function getLastInsertId()
    {
        $statement = $this->connection->prepare('SELECT LAST_INSERT_ID();');
        if (!$statement->execute()) {
            throw new ExecutionException('Query cannot be executed');
        }

        return $statement->fetch(\PDO::FETCH_COLUMN);
    }

    /**
     * @param string $sql
     * @return Statement
     */
    public function prepare(string $sql): Statement
    {
        return new Statement($this->connection->prepare($sql));
    }

    /**
     * @throws ExecutionException
     */
    public function rollback()
    {
        $statement = $this->connection->prepare('ROLLBACK;');
        if (!$statement->execute()) {
            throw new ExecutionException('Query cannot be executed');
        }
    }

    /**
     * @throws ExecutionException
     */
    public function startTransaction()
    {
        $statement = $this->connection->prepare('START TRANSACTION;');
        if (!$statement->execute()) {
            throw new ExecutionException('Query cannot be executed');
        }
    }

    /**
     * @param array $config
     * @return array
     */
    private function buildConnectionArguments(array $config): array
    {
        $dsn = [sprintf('%s:dbname=%s', $config['driver'], $config['database'])];
        $dnsOptions = ['host', 'port'];
        foreach ($dnsOptions as $option) {
            if (isset($config[$option])) {
                $dsn[] = sprintf('%s=%s', $option, $config[$option]);
            }
        }

        $args['dsn'] = implode(';', $dsn);
        $args['username'] = $config['username'] ?? null;
        $args['password'] = $config['password'] ?? null;
        $args['options'] = $config['options'] ?? null;

        return array_values($args);
    }
}