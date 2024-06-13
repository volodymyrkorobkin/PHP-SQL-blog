<?php
include_once "../models/userModel.php";
include_once "../php/validator.php";

class Controller {
    protected $validator;

    public function __construct() {
        $this->validator = new Validator();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    /**
     * Function to check login
     * @return boolean
     */
    public function checkLogin() {
        $userModel = new UserModel();
        try {
            $result = $userModel->validateLogin();
            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    /**
     * Function to validate login
     * @return boolean
     * Sends user to login page if not logged in
     */
    public function validateLogin() {

        $userModel = new UserModel();
        try {
            $result = $userModel->validateLogin();

            if ($result) {
                return true;
            } else {
                header("Location: ../pages/login.php");
            }
        } catch (Exception $e) {
            echo "<script>alert('".$e->getMessage()." ');</script>";
        }
    }
}