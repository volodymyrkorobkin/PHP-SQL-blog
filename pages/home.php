<?php
include_once "../controllers/userController.php";
include_once "../controllers/blogController.php";

$userController = new UserController();
$userController->validateLogin();

include_once "../php/header.php";



$blogController = new BlogController();
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$blogController->viewPosts($page);