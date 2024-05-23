<?php


class requestValidation {
    private $requests;
    private $params;


    public function __construct() {
        $this->requests = [
            "GET" => [],
            "POST" => [
                "addUser" => ["username", "password"]
            ],  
        ];

        $this->params = [
            "username" => "/^[a-zA-Z0-9]{3,20}$/",
            "password" => "/^[a-zA-Z0-9]{6,20}$/",
        ];

        
    }

    public function validateRequest($method, $action, $data) {
        if (!in_array($method, ["GET", "POST"])) {
            $this->rejectRequest(405, "Method not allowed");
        }
        if (!array_key_exists($action, $this->requests[$method])) {
            $this->rejectRequest(400, "Invalid action");
        }
        $this->validateParams($method, $action, $data);
    }



    private function rejectRequest($responseCode = 400, $reason = "Invalid request") {
        http_response_code($responseCode);
        echo json_encode(["error" => $reason]);
        exit();
    }

    private function validateParams($method, $action, $data) {
        $params = $this->requests[$method][$action];
        foreach ($params as $param) {
            if (!array_key_exists($param, $data)) {
                $this->rejectRequest(400, "Missing parameter: $param");
            }
            if (!preg_match($this->params[$param], $data[$param])) {
                $this->rejectRequest(400, "Invalid parameter: $param");
            }
        }
    }
    


}