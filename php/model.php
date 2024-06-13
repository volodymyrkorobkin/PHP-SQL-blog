<?php
include_once "database.php";


class Model {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function validateLogin() {
        if (isset($_SESSION['token'])) {
            $sql = "SELECT * FROM Sessions WHERE session_id = ?";
            $params = [$_SESSION['token']];

            $result = $this->db->fetchOne($sql, $params);

            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}