<?php

namespace Core\Database;

final class QueryBuilder extends Connection
{

    public $validFetchType = ['fetch', 'fetchAll'];

    /**
     * Raw SQL query from database
     *
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function rawQuery(string $sql, array $params = []): bool
    {
        return $this->query($sql, $params);
    }

    /**
     * Raw SQL select query from database
     *
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function rawSelect(string $sql, array $params = [])
    {
        return $this->query($sql, $params, 'fetch');
    }

    /**
     * Raw SQL select all query from database
     *
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function rawSelectAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params, 'fetchAll');
    }

    /**
     * Raw SQL row count query from database
     *
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function rawCount(string $sql, array $params = []): array
    {
        return $this->query($sql, $params, 'fetchAll', true);
    }

    // Do insert sql
    public function insert(string $table, array $params)
    {
        $columns = implode(',', array_keys($params));
        $values = trim(str_repeat('?,', count($params)), ',');

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            $columns,
            $values
        );
        return $this->query($sql, $params);
    }

    // do update sql
    public function update(string $table, array $key, array $params)
    {
        $set = trim(implode('=?,', array_keys($params)) . '=?', ',');
        $sql = sprintf(
            'UPDATE %s SET %s WHERE %s = ?',
            $table,
            $set,
            key($key)
        );

        $params[] = current($key);
        return $this->query($sql, $params);
    }

    // do delete sql
    public function delete(string $table, string $key, string|int $param)
    {
        $sql = sprintf(
            'DELETE FROM %s WHERE %s = ?',
            $table,
            $key
        );

        return $this->query($sql, [$param]);
    }

    /**
     * Select from database
     *
     * @param string $sql
     * @param array $params
     * @return bool|object
     */
    public function select(string $table, string $column, string|int $param)
    {
        $sql = sprintf(
            "SELECT * FROM %s WHERE %s = ? LIMIT 1",
            $table,
            $column
        );

        return $this->query($sql, [$param], 'fetch');
    }

    /**
     * Select all from database
     *
     * @param string $sql
     * @param array $params
     * @return bool|object
     */
    public function selectAll(string $table, array $columns = ['*']): array
    {
        $sql = sprintf(
            "SELECT %s FROM %s",
            implode(',', $columns),
            $table
        );

        return $this->query($sql, fetchType: 'fetchAll');
    }

    private function connection()
    {
        return parent::connect(CONFIG['database']);
    }

    private function query(
        string $sql,
        array $params = [],
        ?string $fetchType = null,
        bool $count = false
    ) {
        $stmt = $this->connection()->prepare($sql);

        $params = array_values($params);
        if (!$fetchType) {
            return $stmt->execute($params);
        }

        if (!in_array($fetchType, $this->validFetchType)) {
            throw new \Exception("{$fetchType} is an invalid Fetch Type.");
        }

        $stmt->execute($params);
        $result = $stmt->{$fetchType}();

        if ($count) {
            return $result->rowCount();
        }

        return $result;
    }
}
