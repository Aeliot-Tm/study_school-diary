<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 16:28
 */

namespace Repository;


use Core\DB\Connection;

abstract class AbstractRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $class;

    /**
     * @param Connection $connection
     * @param string $class
     */
    public function __construct(Connection $connection, string $class)
    {
        $this->connection = $connection;
        $this->class = $class;
    }

    public function find(int $id): array
    {
        //TODO implement
    }
}