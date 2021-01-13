<?php

namespace Core\Blueprint;

use Core\Database\QueryBuilder;

abstract class Models
{
    protected $table;
    protected $fillable;
    protected $key;

    public function save(array $params): bool
    {
        $params = array_filter($params,
            fn($value, $key) => in_array($key, $this->fillable)
            , ARRAY_FILTER_USE_BOTH);

        $columns = implode(',', array_keys($params));
        $values = trim(str_repeat('?,', count($params)), ',');
        $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)',
            $this->table, $columns, $values);

        return $this->execute()->query($sql, array_values($params));
    }

    public function update($id, $params, $key = null)
    {
        $this->key = $key ?? $this->key;

        $params = array_filter($params,
            fn($value, $key) => in_array($key, $this->fillable)
            , ARRAY_FILTER_USE_BOTH);

        array_push($params, $id);

        $set = trim(implode('=?,', array_keys($params)) . '=?', ',');
        $sql = sprintf('UPDATE %s SET %s WHERE %s = ?',
            $this->table, $set, $this->key);

        return $this->execute()->query($sql, array_values($params));
    }

    public function delete($params, $key = null)
    {
        $this->key = $key ?? $this->key;
        $sql = sprintf('DELETE FROM %s WHERE %s = ?',
            $this->table, $this->key);

        return $this->execute()->query($sql, $params);
    }

    public function find(string $param, $key = null): bool | object
    {
        $this->key = $key ?? $this->key;
        $sql = sprintf('SELECT * FROM %s WHERE %s = ?',
            $this->table, $this->key);
        return $this->execute()->select($sql, [$param]);
    }

    public function all(array $params = []): array
    {
        $sql = sprintf('SELECT * FROM %s', $this->table);
        return $this->execute()->selectAll($sql, $params);
    }

    private function execute()
    {
        return new QueryBuilder();
    }
}
