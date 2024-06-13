<?php
include_once "../controllers/controller.php";
include_once "../php/validator.php";
include_once "../models/userModel.php";


class UserController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        $rules = [
            'usename' => 'required||min:6|max:24',
            'password' => 'required||min:8|max:32'
        ];

        try {
            
            if ($this->validator->validate($_POST, $rules)) {
                $userModel = new UserModel();
                $userModel->login($_POST['username'], $_POST['password']);

                header("Location: ../pages/home.php");
            } else {
                throw new Exception("Validation failed");
            } 
        } catch (Exception $e) {
            echo "<script>alert('".$e->getMessage()." ');</script>";
        }
    }

    public function getUsername() {
        $userModel = new UserModel();
        return $userModel->getUsername($_SESSION['token']);
    }

    public function isUserAdmin() {
        $userModel = new UserModel();
        $username = $userModel->getUsername($_SESSION['token']);
        return $userModel->isAdmin($username);
    }
    
    public function logout() {
        echo "Logout function called";
    }
    
    public function addUser() {
        $rules = [
            'usename' => 'required||min:6||max:24',
            'password' => 'required||min:8|max:32'
        ];
        

        if (!$this->validator->validate($_POST, $rules)) {
            echo "<script>alert('Validation failed');</script>";
            return;
        }

        $userModel = new UserModel();

        try {
            $userModel->addUser($_POST['username'], $_POST['password']);

            echo "<script>alert('User added');</script>";
        } catch (Exception $e) {
            echo "<script>alert('User already exists');</script>";
        } 
    }
    
    public function deleteUser() {
        $this->validateLogin();

        $userModel = new UserModel();
        $username = $userModel->getUsername($_SESSION['token']);
        $isAdmin = $userModel->isAdmin($username);

        if (!$isAdmin) {
            echo "<script>alert('You do not have permission to delete users');</script>";
            return;
        }

        $userModel->deleteUser($_GET['id']);
    }
    
    public function updateUser() {
        echo "Update user function called";
    }
}
