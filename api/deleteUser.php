<?php
include_once "../controllers/userController.php";
$userController = new UserController();
$userController->deleteUser();

header("Location: ../pages/admin.php");