<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $db_host = 'mysql';
        $db_user = getenv('MYSQL_DB_USERNAME');
        $db_pass = getenv('MYSQL_DB_PASSWORD');
        $db_name = getenv('MYSQL_DB_DATABASE');

        $this->connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

        if (!$this->connection) {
            die("Помилка підключения до бази данних: " . mysqli_connect_error());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>
