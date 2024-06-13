<?php
include_once "../controllers/controller.php";
include_once "../models/commentModel.php";

class CommentController extends Controller {
    
    public function addComment() {
        $this->validateLogin();

        $rules = [
            'message' => 'required||min:1|',
        ];

        try {
            if ($this->validator->validate($_GET, $rules)) {
                $commentModel = new CommentModel();
                $commentModel->addComment($_GET['message'], $_SESSION['token'], $_GET['postId']);

                header("Location: ../pages/post.php?id=".$_GET['postId']);
            } else {
                throw new Exception("Validation failed");
            }
        } catch (Exception $e) {
            echo "<script>alert('".$e->getMessage()." ');</script>";
        }
    }
}