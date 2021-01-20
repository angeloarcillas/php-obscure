<?php

namespace Core\Blueprint;

use Core\Database\QueryBuilder;

abstract class Models
{
    protected $table;
    protected $fillable;
    protected $key = 'id';

    /**
     * Raw sql
     */
    public function rawQeury(string $sql, array $params = [])
    {
        return $this->builder()->rawQuery($sql, $params);
    }

    /**
     * Raw select sql
     *
     * return 1 data
     */
    public function rawSelectQuery(string $sql, array $params)
    {
        return $this->builder()->rawSelect($sql, $params);
    }

    /**
     * Raw select all query
     *
     * return all
     */
    public function rawSelectAllQuery(string $sql, array $params = [])
    {
        return $this->builder()->rawSelectAll($sql, $params);
    }

    /**
     * Query for INSERT sql
     */
    public function create(array $params): bool
    {
        $params = $this->filter($params);
        return $this->builder()->insert($this->table, $params);
    }

    /**
     * Query for UPDATE sql
     */
    public function update($id, $params, $key = null)
    {
        $key = $key ? [$key => $id] : [$this->key => $id];
        $params = $this->filter($params);

        return $this->builder()->update($this->table, $key, $params);
    }

    /**
     * Query for DELETE sql
     */
    public function delete($id, $key = null)
    {
        // check if user defined a key
        $key = $key ?? $this->key;

        // run delete sql
        return $this->builder()->delete($this->table, $key, $id);
    }

    /**
     * Return specific data from table
     */
    public function find(
        string $param,
        ?string $key = null,
        ?string $table = null
    ): bool|object {
        // check if user defined a table
        $table = $table ?? $this->table;

        // check if user defined a key
        $key = $key ?? $this->key;

        // run select sql
        return $this->builder()->select($table, $key, $param);
    }

    /**
     * Return all data from table
     */
    public function all(?string $table = null): array
    {
        // check if user defined a table
        $this->table = $table ?? $this->table;

        // run select all sql
        return $this->builder()->selectAll($this->table);
    }

    /**
     * Filter $request with $this->fillable
     *
     * Return all request that can be filled
     */
    protected function filter($params)
    {
        return array_filter(
            // request
            $params,

            // arrow function | return fillable requests
            fn ($x, $key) => in_array($key, $this->fillable),

            // use array keys & values
            ARRAY_FILTER_USE_BOTH
        );
    }

    // create Querybuilderer instance
    private function builder()
    {
        return new Querybuilder();
    }
}
