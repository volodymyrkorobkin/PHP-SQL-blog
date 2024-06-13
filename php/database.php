<?php


class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $this->connection = new PDO('mysql:host=localhost;dbname=php_blog', 'root', 'root');
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
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

    private function runQuery($query, $params = []) {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            echo 'Query failed: ' . $e->getMessage();
            exit;
        }
    }

    public function fetchAll($query, $params = []) {
        return $this->runQuery($query, $params)->fetchAll();
    }

    public function fetchOne($query, $params = []) {
        return $this->runQuery($query, $params)->fetch();
    }

    public function execute($query, $params = []) {
        $this->runQuery($query, $params);
    }
}
