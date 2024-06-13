<?php
include_once "../controllers/postController.php";

include_once "../php/header.php";

$postController = new PostController();
if (!isset($_GET['id'])) {
    echo "No post id provided";
    return;
}
$postController->viewPost($_GET['id']);