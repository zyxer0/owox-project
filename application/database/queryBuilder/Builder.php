<?php

namespace App\DB\QueryBuilder;

interface Builder
{

    //public static function getInstance(): Builder;

    /**
     * @param array $fields
     * @return Builder
     */
    public function select(array $fields): Builder;

    /**
     * @return Builder
     */
    public function count(): Builder;

    /**
     * @param string $table
     * @return Builder
     */
    public function delete($table): Builder;

    /**
     * @param string $table
     * @return Builder
     */
    public function update(string $table): Builder;

    /**
     * @param string $table
     * @return Builder
     */
    public function insert(string $table): Builder;

    /**
     * @param string $table
     * @param $alias
     * @return Builder
     */
    public function from(string $table, string $alias = null): Builder;

    /**
     * @param $values
     * example ['field1'=>'value1', 'field2'=>'value2']
     * OR instance App\DB\ActiveRecord\BaseActiveRecord
     * @return Builder
     */
    public function set($values): Builder;

    /**
     * @param string $where
     * @return Builder
     */
    public function where(string $where): Builder;

    /**
     * @param int $start
     * @param int $offset
     * @return Builder
     */
    public function limit(int $start, int $offset = null): Builder;

    /**
     * @param string $orderBy
     * @return Builder
     */
    public function orderBy(string $orderBy): Builder;

    /**
     * @param string $table
     * @param string $alias
     * @param string $on
     * @return Builder
     */
    public function leftJoin(string $table, string $alias, string $on): Builder;

    /**
     * @param string $table
     * @param string $alias
     * @param string $on
     * @return Builder
     */
    public function innerJoin(string $table, string $alias, string $on): Builder;

    /**
     * @param string $groupBy
     * @return Builder
     */
    public function groupBy(string $groupBy): Builder;

    /**
     * @return string
     */
    public function getSQL(): string;

    /**
     * clear the SLQ query
     */
    public function clear(): void;
}