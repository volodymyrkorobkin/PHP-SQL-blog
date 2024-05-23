<?php
include_once "DBWorker.php";


class UsersManager {
    private $db;

    public function __construct(DBWorker $db) {
        $this->db = $db;
    }

    public function addNewUser($username, $password) {
        $passwordEnc = hash("bcrypt", $password);
        $query = "insert into users (username, password) values (?, ?);";
        $params = [$username, $passwordEnc];
        $this->db->insert($query, $params);
    }

    // public function getUserById($userId) {
    //     $query = "select * from users where id = ?;";
    //     $params = [$userId];
    //     $response = $this->db->fetchOne($query, $params);

    //     if (!$response) {
    //         return null;
    //     }

    //     $user = new User($response['id'], $response['username'], $response['email'], $response['password'], $response['created_on'], $response['updated_on']);
    //     return $user;
    // }

    //public function editUser() {}

}