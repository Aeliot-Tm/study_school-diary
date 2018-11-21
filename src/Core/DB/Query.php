<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 04.11.2018
 * Time: 0:49
 */

namespace Core\DB;

/**
 * Class Query
 */
class Query
{
    const TYPE_DELETE = 'DELETE';
    const TYPE_INSERT = 'INSERT';
    const TYPE_SELECT = 'SELECT';
    const TYPE_UPDATE = 'UPDATE';

    private $type;

    /**
     * @var array
     */
    private $statementSegments = [
        'delete' => [],
        'select' => [],
        'from' => null,
        'insert' => null,
        'insertCounterpart' => null,
        'join' => [],
        'set' => [],
        'where' => [],
        'values' => [],
        'fields' => [],
        'orderBy' => [],
        'groupBy' => [],
        'limit' => 0,
        'offset' => 0,
    ];

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @return string
     */
    public function getSQL()
    {
        switch ($this->type) {
            case self::TYPE_DELETE:
                return $this->buildDeleteQuery();
            case self::TYPE_INSERT:
                return $this->buildInsertQuery();
            case self::TYPE_SELECT:
                return $this->buildSelectQuery();
            case self::TYPE_UPDATE:
                return $this->buildUpdateQuery();
        }

        throw new \LogicException('Invalid type');
    }

    /**
     * @param array ...$items
     * @return $this
     */
    public function select(...$items)
    {
        $this->setType(self::TYPE_SELECT);
        $this->setStatement('select', $items);

        return $this;
    }

    /**
     * @param array ...$items
     * @return $this
     */
    public function addSelect(...$items)
    {
        $this->setType(self::TYPE_SELECT);
        $this->addStatement('select', $items);

        return $this;
    }

    /**
     * @param string $from
     * @param string|null $alias
     * @return $this
     */
    public function from(string $from, string $alias = null)
    {
        $this->setStatement('from', $alias ? sprintf('%s AS %s', $from, $alias) : $from);

        return $this;
    }

    /**
     * @param string $from
     * @param string|null $alias
     * @return $this
     */
    public function update(string $from, string $alias = null)
    {
        $this->setType(self::TYPE_UPDATE);
        $this->setStatement('from', $alias ? sprintf('%s AS %s', $from, $alias) : $from);

        return $this;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function delete(...$items)
    {
        $this->setType(self::TYPE_DELETE);
        if ($items) {
            $this->addStatement('delete', $items);
        }

        return $this;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function addDelete(...$items)
    {
        $this->setType(self::TYPE_DELETE);
        $this->addStatement('delete', $items);

        return $this;
    }

    /**
     * @param string $table
     * @param string|null $counterpart
     * @return $this
     */
    public function insertInto(string $table, string $counterpart = null)
    {
        $this->setType(self::TYPE_INSERT);
        $this->setStatement('insert', $table);
        if ($counterpart) {
            $this->setStatement('insertCounterpart', $counterpart);
        }

        return $this;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function fields(...$items)
    {
        $this->setStatement('fields', $items);

        return $this;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function addFields(...$items)
    {
        $this->addStatement('fields', $items);

        return $this;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function values(...$items)
    {
        $this->setStatement('values', $items);

        return $this;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function addValues(...$items)
    {
        $this->addStatement('values', $items);

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return $this
     * @internal param array ...$items
     */
    public function addSet(string $key, $value)
    {
        $this->addStatement('set', [sprintf('%s=%s', $key, $value)]);

        return $this;
    }

    /**
     * @param array ...$items
     * @return $this
     */
    public function where(...$items)
    {
        $this->setStatement('where', $items);

        return $this;
    }

    /**
     * @param array ...$items
     * @return $this
     */
    public function andWhere(...$items)
    {
        $this->checkItems('where', $items);

        if ($this->hasStatement('where')) {
            $items = array_map(
                function (string $item) {
                    return " AND $item";
                },
                $items
            );
        }
        $this->addStatement('where', $items);

        return $this;
    }

    /**
     * @param array ...$items
     * @return $this
     */
    public function orderBy(...$items)
    {
        $this->setStatement('orderBy', $items);

        return $this;
    }

    /**
     * @param array ...$items
     * @return $this
     */
    public function addOrderBy(...$items)
    {
        $this->addStatement('orderBy', $items);

        return $this;
    }

    /**
     * @param array ...$items
     * @return $this
     */
    public function groupBy(...$items)
    {
        $this->setStatement('groupBy', $items);

        return $this;
    }

    /**
     * @param array ...$items
     * @return $this
     */
    public function addGroupBy(...$items)
    {
        $this->addStatement('groupBy', $items);

        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit)
    {
        $this->setStatement('limit', $limit);

        return $this;
    }

    public function insertCounterpart(string $counterpart)
    {
        $this->setStatement('insertCounterpart', $counterpart);
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function offset(int $offset)
    {
        $this->setStatement('offset', $offset);

        return $this;
    }

    /**
     * @param $statement
     * @param string $alias
     * @param string $conditions
     * @return $this
     */
    public function innerJoin($statement, string $alias, string $conditions)
    {
        $this->addJoin($statement, $alias, $conditions, Join::INNER);

        return $this;
    }

    /**
     * @param $statement
     * @param string $alias
     * @param string $conditions
     * @return $this
     */
    public function leftJoin($statement, string $alias, string $conditions)
    {
        $this->addJoin($statement, $alias, $conditions, Join::LEFT);

        return $this;
    }

    /**
     * @param $statement
     * @param string $alias
     * @param string $conditions
     * @return $this
     */
    public function rightJoin($statement, string $alias, string $conditions)
    {
        $this->addJoin($statement, $alias, $conditions, Join::RIGHT);

        return $this;
    }

    /**
     * @param $statement
     * @param string $alias
     * @param string $conditions
     * @return $this
     */
    public function join($statement, string $alias, string $conditions)
    {
        $this->addJoin($statement, $alias, $conditions);

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setParameter(string $key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * @param string|Query $statement
     * @param string $alias
     * @param string $conditions
     * @param string|null $type
     */
    private function addJoin($statement, string $alias, string $conditions, string $type = null)
    {
        $this->addStatement('join', [new Join($statement, $alias, $conditions, $type)]);
    }

    /**
     * @param string $statement
     * @param array $items
     */
    private function addStatement(string $statement, array $items)
    {
        $this->checkItems($statement, $items);

        foreach ($items as $item) {
            $this->statementSegments[$statement][] = $item;
        }
    }

    /**
     * @return string
     */
    private function buildInsertQuery(): string
    {
        $sql = sprintf('INSERT %s INTO %s', $this->getStatement('insertCounterpart'), $this->getStatement('insert'));
        $sql .= sprintf(' (%s)', implode(',', $this->getStatement('fields')));
        $values = $this->getStatement('values');

        if ($values) {
            $sql .= ' VALUES '.implode(
                    ', ',
                    array_map(
                        function ($row) {
                            if (is_array($row)) {
                                $row = implode(',', $row);
                            }

                            return "($row)";
                        },
                        $values
                    )
                );
        } else {
            $sql .= $this->buildSelectQuery();
        }

        return $sql;
    }

    /**
     * @return string
     */
    private function buildSelectQuery(): string
    {
        $sql = sprintf('SELECT %s', implode(', ', $this->getStatement('select')));
        $sql .= sprintf(' FROM %s', $this->getStatement('from'));
        if ($this->getStatement('join')) {
            $sql .= ' '.implode(' ', $this->getStatement('join'));
        }
        if ($this->getStatement('where')) {
            $sql .= ' WHERE '.implode(' ', $this->getStatement('where'));
        }
        if ($this->getStatement('groupBy')) {
            $sql .= ' GROUP BY '.implode(', ', $this->getStatement('groupBy'));
        }
        if ($this->getStatement('orderBy')) {
            $sql .= ' ORDER BY '.implode(', ', $this->getStatement('orderBy'));
        }
        if ($this->getStatement('limit')) {
            $sql .= sprintf(' LIMIT %d', $this->getStatement('limit'));
        }
        if ($this->getStatement('offset')) {
            $sql .= sprintf(' OFFSET %d', $this->getStatement('offset'));
        }

        return $sql;
    }

    /**
     * @return string
     */
    private function buildUpdateQuery(): string
    {
        $sql = sprintf('UPDATE %s ', $this->getStatement('from'));
        if ($this->getStatement('join')) {
            $sql .= ' '.implode(' ', $this->getStatement('join'));
        }
        if ($this->getStatement('set')) {
            $sql .= '  SET '.implode(', ', $this->getStatement('set'));
        }
        if ($this->getStatement('where')) {
            $sql .= ' WHERE '.implode(' ', $this->getStatement('where'));
        }
        if ($this->getStatement('limit')) {
            $sql .= sprintf(' LIMIT %d', $this->getStatement('limit'));
        }
        if ($this->getStatement('offset')) {
            $sql .= sprintf(' OFFSET %d', $this->getStatement('offset'));
        }

        return $sql;
    }

    /**
     * @return string
     */
    private function buildDeleteQuery(): string
    {
        $sql = 'DELETE ';
        if ($this->getStatement('delete')) {
            $sql .= ' '.implode(', ', $this->getStatement('delete'));
        }
        $sql .= sprintf(' FROM %s ', $this->getStatement('from'));
        if ($this->getStatement('join')) {
            $sql .= ' '.implode(' ', $this->getStatement('join'));
        }
        if ($this->getStatement('where')) {
            $sql .= ' WHERE '.implode(' ', $this->getStatement('where'));
        }
        if ($this->getStatement('limit')) {
            $sql .= sprintf(' LIMIT %d', $this->getStatement('limit'));
        }
        if ($this->getStatement('offset')) {
            $sql .= sprintf(' OFFSET %d', $this->getStatement('offset'));
        }

        return $sql;
    }

    /**
     * @param string $segment
     * @return mixed
     */
    private function getStatement(string $segment)
    {
        return $this->statementSegments[$segment];
    }

    /**
     * @param string $segment
     * @return bool
     */
    private function hasStatement(string $segment): bool
    {
        return (bool)$this->statementSegments[$segment];
    }

    /**
     * @param string $segment
     * @param mixed $value
     * @return mixed
     */
    private function setStatement(string $segment, $value)
    {
        return $this->statementSegments[$segment] = $value;
    }

    /**
     * @param string $type
     */
    private function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @param string $statement
     * @param array $items
     * @return array|mixed
     */
    private function expandItems(string $statement, array $items)
    {
        $first = reset($items);
        if (is_array($first)) {
            if (count($first) > 1 || $this->isFirstAnArray($first)) {
                throw new \InvalidArgumentException(sprintf('Invalid arguments passed to %s', $statement));
            }
            $items = $first;
        }

        return $items;
    }

    /**
     * @param array $items
     * @return bool
     */
    private function isFirstAnArray(array $items): bool
    {
        $first = reset($items);

        return is_array($first);
    }

    /**
     * @param string $statement
     * @param array $items
     */
    private function checkItems(string $statement, array $items)
    {
        if (is_array(reset($items))) {
            throw new \InvalidArgumentException(sprintf('Invalid arguments passed to %s', $statement));
        }
    }
}