<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 16:32
 */

namespace Core\DB;

/**
 * Class EntityManager
 */
class EntityManager
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var array
     */
    private $entitiesConfig;

    /**
     * @param Connection $connection
     * @param array $entitiesConfig
     */
    public function __construct(Connection $connection, array $entitiesConfig)
    {
        $this->connection = $connection;
        $this->entitiesConfig = $entitiesConfig;
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * @param string $entityClass
     * @return string
     */
    public function getTable(string $entityClass): string
    {
        if (!array_key_exists($entityClass, $this->entitiesConfig)) {
            throw new \InvalidArgumentException(sprintf('Not registered entity: %s', $entityClass));
        }

        return $this->entitiesConfig[$entityClass]['table'];
    }
}