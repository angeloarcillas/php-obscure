<?php

namespace Core\Database;

final class QueryBuilder extends Connection
{

    // set validate fetch type
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
    public function rawSelect(string $sql, array $params = []): bool|object
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

    /**
     * Execute INSERT sql
     */
    public function insert(string $table, array $params)
    {
        // set columns of insert sql
        $columns = implode(',', array_keys($params));

        // set values of inset sql
        $values = trim(str_repeat('?,', count($params)), ',');

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table, $columns, $values
        );

        return $this->query($sql, $params);
    }

    /**
     * Execute UPDATE sql
     */
    public function update(string $table, array $key, array $params)
    {
        // set columns to update
        $set = trim(implode('=?,', array_keys($params)) . '=?', ',');

        $sql = sprintf(
            'UPDATE %s SET %s WHERE %s = ?',
            $table,
            $set,
            key($key)
        );

        // append key value
        $params[] = current($key);

        return $this->query($sql, $params);
    }

    /**
     * Execute DELETE sql
     */
    public function delete(string $table, string $key, string|int $param)
    {
        $sql = sprintf(
            'DELETE FROM %s WHERE %s = ?',
            $table, $key
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
            implode(',', $columns), // set columns to fetch
            $table
        );

        return $this->query($sql, fetchType: 'fetchAll');
    }

    // Establish connection
    private function connection()
    {
        return parent::connect(CONFIG['database']);
    }

    /**
     * Execute query
     */
    private function query(
        string $sql,
        array $params = [],
        ?string $fetchType = null,
        bool $count = false
    ) {
        // prepare sql
        $stmt = $this->connection()->prepare($sql);

        // get parameters
        $params = array_values($params);

        // if no fetch type then execute
        if (!$fetchType) {
            return $stmt->execute($params);
        }

        // if invalid fetch type, throw error
        if (!in_array($fetchType, $this->validFetchType)) {
            throw new \Exception("{$fetchType} is an invalid Fetch Type.");
        }

        // execute sql
        $stmt->execute($params);

        // fetch from database
        $result = $stmt->{$fetchType}();

        // if count, return numbe of row fetched
        if ($count) {
            return $result->rowCount();
        }

        // return fetched result
        return $result;
    }
}
