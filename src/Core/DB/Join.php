<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 04.11.2018
 * Time: 0:52
 */

namespace Core\DB;


class Join
{
    const INNER = 'INNER';
    const LEFT = 'LEFT';
    const RIGHT = 'RIGHT';

    /**
     * @var string
     */
    private $statement;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $conditions;

    /**
     * @var null|string
     */
    private $type;

    /**
     * Join constructor.
     * @param string|Query $statement
     * @param string $alias
     * @param string $conditions
     * @param string|null $type
     */
    public function __construct($statement, string $alias, string $conditions, string $type = null)
    {
        $this->statement = $statement;
        $this->alias = $alias;
        $this->conditions = $conditions;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s JOIN %s AS %s ON %s',
            (string)$this->type,
            (string)$this->statement,
            $this->alias,
            $this->conditions
        );
    }
}