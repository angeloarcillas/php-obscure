<?php

namespace Core\Database;

class Connection
{
    /**
     * Establish connection to database
     */
    protected static function connect($config)
    {
          return new \PDO(
              $config['connection'].';dbname='.$config['name'],
              $config['username'],
              $config['password'],
              $config['options']
          );
    }
}