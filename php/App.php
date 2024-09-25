<?php
include_once 'DBWorker.php';
include_once 'PostsManager.php';
include_once 'requestValidation.php';

class App {
    private $db;
    private $postsManager;
    private $requestValidation;

    public function __construct() {
        $this->db = new DBWorker();
        $this->postsManager = new PostsManager($this->db);
        $this->requestValidation = new requestValidation();
    }

    public function processRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $action = $_GET['action'];

        $this->validateRequest($method, $action, json_decode(file_get_contents('php://input'), true));  
    }

    public function validateRequest($method, $action, $data) {
        $this->requestValidation->validateRequest($method, $action, $data);
    }
}

//test
$app = new App();