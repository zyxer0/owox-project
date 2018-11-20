<?php

namespace App\DB\QueryBuilder;

class MySQLBuilder implements Builder
{
    private $query;
    private $queryType;
    private $fields = [];
    private $isCount = false;
    private $from = ['table' => '', 'alias' => null];
    private $where = [];
    private $limit = ['start' => null, 'offset' => null];
    private $orderBy = [];
    private $leftJoin = [];
    private $innerJoin = [];
    private $groupBy = [];

    public function select(array $fields): Builder
    {
        $this->queryType = 'SELECT';
        $this->fields = $fields;
        return $this;
    }

    public function count(): Builder
    {
        $this->isCount = true;
        return $this;
    }

    public function delete(): Builder
    {
        // TODO: Implement delete() method.
        return $this;
    }

    public function update(string $table): Builder
    {
        // TODO: Implement update() method.
        return $this;
    }

    public function insert(string $table): Builder
    {
        // TODO: Implement insert() method.
        return $this;
    }

    public function from(string $table, string $alias = null): Builder
    {
        $this->from['table'] = $table;
        $this->from['alias'] = $alias;
        return $this;
    }

    public function set(string $key, string $value): Builder
    {
        // TODO: Implement set() method.
        return $this;
    }

    public function where(string $where): Builder
    {
        $this->where[] = $where;
        return $this;
    }

    public function limit(int $start, int $offset = null): Builder
    {
        $this->limit['start'] = $start;
        $this->limit['offset'] = $offset;
        return $this;
    }

    public function orderBy(string $orderBy): Builder
    {
        $this->orderBy[] = $orderBy;
        return $this;
    }

    public function leftJoin(string $table, string $alias, string $on): Builder
    {
        $leftJoin = [
            'table' => $table,
            'alias' => $alias,
            'on' => $on
        ];
        $this->leftJoin[] = $leftJoin;
        //$this->query .= ' LEFT JOIN ' . $table . ' AS ' . $alias . ' ON ' . $on;
        return $this;
    }

    public function innerJoin(string $table, string $alias, string $on): Builder
    {
        $innerJoin = [
            'table' => $table,
            'alias' => $alias,
            'on' => $on
        ];
        $this->innerJoin[] = $innerJoin;
        //$this->query .= ' INNER JOIN ' . $table . ' AS ' . $alias . ' ON ' . $on;
        return $this;
    }

    public function groupBy(string $groupBy): Builder
    {
        $this->groupBy[] = $groupBy;
        return $this;
    }

    public function getSQLObject(): Builder
    {
        return $this;
    }

    public function getSQL(): string
    {
        $this->validateSQL();
        $this->buildSQL();
        return $this->query;
    }

    private function buildSQL()
    {
        $this->query = $this->queryType;

        if (!$this->isCount) {
            $this->query .= ' '.implode(', ', $this->fields);
        } else {
            $this->query .= ' COUNT(*) as count';
            $this->isCount = false;
        }

        $this->query .= ' FROM ' . $this->from['table'] . ($this->from['alias'] !== null ? ' AS '
                . $this->from['alias'] : '');

        // todo JOIN

        if (!empty($this->where)) {
            $this->query .= ' WHERE ' . implode(' ', $this->where);
        }

        if (!empty($this->orderBy)) {
            $this->query .= ' ORDER BY ' . implode(', ', $this->orderBy);
        }

        if (!empty($this->groupBy)) {
            $this->query .= ' GROUP BY ' . implode(', ', $this->groupBy);
        }

        if (isset($this->limit['start'])) {
            $this->query .= ' LIMIT ' . $this->limit['start']
                . (!empty($this->limit['offset']) ? ', '.$this->limit['offset'] : '');
        }
    }

    private function validateSQL()
    {
        // Validation SQL
        if ($this->queryType == 'SELECT') {
            if (empty($this->fields) && !$this->isCount) {
                throw new \Exception('Empty SELECT fields');
            }

            if (empty($this->from['table'])) {
                throw new \Exception('Empty table name');
            }
        }
    }

    /**
     * clear the SLQ query
     */
    public function clear(): void
    {
        $this->query = '';
        $this->queryType = '';
        $this->fields = [];
        $this->isCount = false;
        $this->from = ['table' => '', 'alias' => null];
        $this->where = [];
        $this->limit = ['start' => null, 'offset' => null];
        $this->orderBy = [];
        $this->leftJoin = [];
        $this->innerJoin = [];
        $this->groupBy = [];
    }
}