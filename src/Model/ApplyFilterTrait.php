<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 18.11.2018
 * Time: 3:01
 */

namespace Model;


use Core\DB\Query;

trait ApplyFilterTrait
{
    /**
     * @param Query $query
     * @param array $filter
     */
    protected function applyFilter(Query $query, array $filter)
    {
        foreach ($filter as $key => $item) {
            if (is_array($item)) {
                $valueKeys = [];
                foreach ($item as $index => $value) {
                    $valueKey = sprintf('%s_%s', $key, $index);
                    $valueKeys[] = ":$valueKey";
                    $query->setParameter($valueKey, $item);
                }
                $query->andWhere('%s IN (%s)', $key, implode(',', $valueKeys));
            } else {
                $query->andWhere('%s = :%s', $key, $key);
                $query->setParameter($key, $item);
            }
        }
    }
}