<?php
include_once "../php/Model.php";

class PostModel extends Model {
    public function __construct() {
        parent::__construct();
    }

    public function getPosts($page = 1, $limit = 10) {
        $limit = intval($limit);
        $offset = intval(($page - 1) * $limit);
    
        $sql = "SELECT * FROM Posts ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $posts = $this->db->fetchAll($sql);

        $totalPosts = $this->db->fetchOne("SELECT COUNT(*) as total FROM Posts");
        $totalPages = ceil($totalPosts['total'] / $limit);

        return ['posts' => $posts, 'totalPages' => $totalPages];
    }

    public function getPost($id) {
        $sql = "SELECT *FROM Posts WHERE Posts.id = ?";
        $params = [$id];
        return $this->db->fetchOne($sql, $params);
    }

    public function addPost($title, $description, $content, $userId) {
        $sql = "INSERT INTO Posts (title, description, content, user_id) VALUES (?, ?, ?, ?)";
        $params = [$title, $description, $content, $userId];
        $this->db->execute($sql, $params);
    }

    public function updatePost($id, $title, $description, $content) {
        $sql = "UPDATE Posts SET title = ?, description = ?, content = ? WHERE id = ?";
        $params = [$title, $description, $content, $id];
        $this->db->execute($sql, $params);
    }

    public function deletePost($id) {
        $sql = "DELETE FROM Posts WHERE id = ?";
        $params = [$id];
        $this->db->execute($sql, $params);
    }


}