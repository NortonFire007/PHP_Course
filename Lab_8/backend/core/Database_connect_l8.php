<?php

class Database_connect_l8
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $this->connection = new mysqli(
            "mysql",
            getenv('MYSQL_DB_USERNAME'),
            getenv('MYSQL_DB_PASSWORD'),
            getenv('MYSQL_DB_DATABASE')
        );

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }


    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database_connect_l8();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
