<?php
include_once "../php/model.php";


class UserModel extends Model {
    public function __construct() {
        parent::__construct();
    }

    public function login($username, $password) {     
        $sql = "SELECT * FROM Users WHERE username = ?";
        $params = [$username];

        $result = $this->db->fetchOne($sql, $params);

        if ($result) {
            if (password_verify($password, $result['password'])) {
                $token = $this->generateToken();
                $this->addSession($result['id'], $token);
                $_SESSION['token'] = $token;
                return true;
                
            } else {
                throw new Exception("Invalid password");
            }
        } else {
            throw new Exception("User not found");
        }
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

    public function addUser($username, $password) {

        $sql = "SELECT * FROM Users WHERE username = ?";
        $params = [$username];
        $result = $this->db->fetchOne($sql, $params);

        if ($result) {
            throw new Exception("User already exists");
        } 
        $sql = "INSERT INTO Users (username, password) VALUES (?, ?)";
        $params = [$username, password_hash($password, PASSWORD_DEFAULT)];

        $this->db->execute($sql, $params);
    }


    /** 
    * Get the username of the user with the given session
    * @param string $session
    * @return string
    * @throws Exception if the user is not found
    */
    public function getUsername($session) {
        $sql = "SELECT username FROM Users JOIN Sessions ON Users.id = Sessions.user_id WHERE session_id = ?";
        $params = [$session];
        $result = $this->db->fetchOne($sql, $params);

        if (!$result) {
            throw new Exception("User not found");
        }

        return $result['username'];
    }

    public function getUserIdBySession($session) {
        $sql = "SELECT user_id FROM Sessions WHERE session_id = ?";
        $params = [$session];
        $result = $this->db->fetchOne($sql, $params);

        if (!$result) {
            throw new Exception("User not found");
        }

        return $result['user_id'];
    }

    public function getUserNameById($id) {
        $sql = "SELECT username FROM Users WHERE id = ?";
        $params = [$id];
        $result = $this->db->fetchOne($sql, $params);

        if (!$result) {
            throw new Exception("User not found");
        }

        return $result['username'];
    }

    public function isAdmin($username) {
        $sql = "SELECT * FROM Users WHERE username = ?";
        $params = [$username];
        $result = $this->db->fetchOne($sql, $params);

        if (!$result) {
            throw new Exception("User not found");
        }

        return $result['isAdmin'];
    }

    private function addSession($userId, $token) {
        $sql = "INSERT INTO Sessions (user_id, session_id) VALUES (?, ?)";
        $params = [$userId, $token];

        $this->db->execute($sql, $params);
    }

    

    private function generateToken($len = 32) {
        return bin2hex(random_bytes(32));
    }

    public function getUsers() {
        $sql = "SELECT * FROM Users";
        return $this->db->fetchAll($sql);
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM Users WHERE id = ?";
        $params = [$id];
        $this->db->execute($sql, $params);
    }
}