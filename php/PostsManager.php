<?php
include_once "DBWorker.php";
include_once "Post.php";


class PostsManager {
    private $db;

    public function __construct(DBWorker $db) {
        $this->db = $db;
    }

    public function getPostById($postId) {
        $query = "select * from posts where id = ?;";
        $params = [$postId];
        $response = $this->db->fetchOne($query, $params);

        if (!$response) {
            return null;
        }

        $post = new Post($response['id'], $response['user_id'], $response['title'], 
                        $response['description'], $response['content'], $response['created_on'], $response['updated_on']);
        return $post;
    }

    public function editPost() {}


}




