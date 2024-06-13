<?php
include_once "../php/Model.php";
include_once "../models/userModel.php";

class CommentModel extends Model {
    public function __construct() {
        parent::__construct();
    }

    public function addComment($message, $token, $postId) {
        $userModel = new UserModel();
        $username = $userModel->getUsername($token);

        $sql = "INSERT INTO Comments (message, name, post_id) VALUES (?, ?, ?)";
        $params = [$message, $username, $postId];
        $this->db->execute($sql, $params);
    }

    public function getComments($postId) {
        $sql = "SELECT * FROM Comments WHERE post_id = ?";
        $params = [$postId];
        return $this->db->fetchAll($sql, $params);
    }
}