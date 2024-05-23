<?php


class DBWorker {
    private $connection;
    
    public function __construct() {
        try {
            $this->connection = new PDO('mysql:host=localhost;dbname=php_blog', 'root', 'root');
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    private function runQuery($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll($query, $params = []) {
        return $this->runQuery($query, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOne($query, $params = []) {
        return $this->runQuery($query, $params)->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($query, $params = []) {
        $this->runQuery($query, $params);
    }
}