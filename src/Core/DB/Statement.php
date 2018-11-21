<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 16:45
 */

namespace Core\DB;


class Statement
{
    /**
     * @var \PDOStatement
     */
    private $statement;

    /**
     * Statement constructor.
     * @param \PDOStatement $statement
     */
    public function __construct(\PDOStatement $statement)
    {
        $this->statement = $statement;
    }

    /**
     * @param array|null $parameters
     * @return bool
     */
    public function execute(array $parameters = null): bool
    {
        return $this->statement->execute($parameters);
    }

    /**
     * @param int|null $fetchStyle
     * @return mixed
     * @see \PDOStatement::fetch()
     */
    public function fetch(int $fetchStyle = \PDO::FETCH_COLUMN)
    {
        return $this->statement->fetch($fetchStyle);
    }

    /**
     * @param int|null $fetchStyle
     * @return mixed
     * @see \PDOStatement::fetchAll()
     */
    public function fetchAll(int $fetchStyle = \PDO::FETCH_COLUMN)
    {
        return $this->statement->fetchAll($fetchStyle);
    }
}
