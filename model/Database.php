<?php
require_once '../Config/config.php';

class Database {
    private static $instance;
    private $connection;

    private function __construct() {
        $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
          
        }
        return self::$instance;
    }

    public function getConnection() {
       
        return $this->connection;
        
    }
}

?>