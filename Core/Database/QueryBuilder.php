<?php
namespace Core\Database;

class QueryBuilder extends Connection
{

    // private object $conn;

    /**
     * Start buffer then establish connection
     */
    public function __construct()
    {
      ob_start();
      // $this->conn = parent::connect($config);
    }

    /**
     * Unset connection then flush buffer
     */
    public function __destruct()
    {
      // unset($this->conn);
      ob_end_flush();
    }


    /**
     * Query from database
     *
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function query(string $sql, array $params = []): bool
    {
      return $this->connection()->prepare($sql)->execute($params);
    }

    /**
     * Select from database
     *
     * @param string $sql
     * @param array $params
     * @return bool|object
     */
    public function select(string $sql, array $params = []): bool|object
    {
      $stmt = $this->connection()->prepare($sql);
      $stmt->execute($params);
      return $stmt->fetch();
    }

    /**
     * Select all from database
     *
     * @param string $sql
     * @param array $params
     * @return bool|object
     */
    public function selectAll(string $sql, array $params = []): array
    {
      $stmt = $this->connection()->prepare($sql);
      $stmt->execute($params);
      return $stmt->fetchAll();
    }

    /**
     * Count all rows from database
     *
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function rowCount(string $sql, array $params = []): int
    {
      $stmt = $this->connection()->prepare($sql);
      $stmt->execute($params);
      return $stmt->rowCount();
    }

    private function connection()
    {
      return parent::connect(CONFIG['database']);
    }
}