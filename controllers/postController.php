<?php
include_once "../controllers/controller.php";
include_once "../models/postModel.php";
include_once "../models/userModel.php";
include_once "../models/commentModel.php";

class PostController extends Controller {
    
    private $postModel;
    private $userModel;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getPost($id) {
        $postModel = new PostModel();
        return $postModel->getPost($id);
    }

    public function viewPost($id) {
        $postModel = new PostModel();
        $userModel = new UserModel();
        $commentModel = new CommentModel();

        $post = $postModel->getPost($id);
        $user = $userModel->getUserNameById($post['user_id']);
        $comments = $commentModel->getComments($id);

        
        
        if ($post) {
            ?>
                <h1><?php echo $post["title"] ?></h1>
                <h3><?php echo $post["description"] ?></h3>
                <p><?php echo $post['content'] ?></p>
                <p>Posted by: <?php echo $user ?></p>
                <p>Posted on: <?php echo $post['created_on'] ?></p>

                <?php
                    if ($post['user_id'] == $userModel->getUserIdBySession($_SESSION['token'])) {
                        ?>
                            <a href="editPost.php?id=<?php echo $post['id']; ?>">Edit</a>
                            <a href="/api/deletePost.php?id=<?php echo $post['id']; ?>">Delete</a>
                        <?php
                    }

                ?>

                <h2>Comments</h2>
            <?php

            if ($comments) {
                foreach ($comments as $comment) {
                    ?>  
                        <h4><?php echo $comment['name'] ?></h4>
                        <h5><?php echo $comment['message'] ?></h5>
                        <p>Posted on: <?php echo $comment['created_on'] ?></p>
                    <?php
                }
            } else {
                echo "No comments found";
            }

            ?>

            <form action="/api/addComment.php" method="get">
                <input type="hidden" name="postId" value="<?php echo $post['id'] ?>">
                <textarea name="message" placeholder="Add a comment"></textarea>
                <input type="submit" value="Add Comment">
            </form>
            <?php



        } else {
            echo "Post not found";
        }
    }
    
    public function addPost() {
        $this->validateLogin();

        $userModel = new UserModel();

        if (!$userModel->isAdmin($userModel->getUsername($_SESSION['token']))) {
            header("Location: /pages/home.php");
            exit;
        }


        try {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $content = $_POST['content'];

            $userModel = new UserModel();
            $userId = $userModel->getUserIdBySession($_SESSION['token']);

            $postModel = new PostModel();
            $postModel->addPost($title, $description, $content, $userId);

            header("Location: /pages/home.php");
        } catch (Exception $e) {
            return "Please fill in all fields";
        }
        return $this->postModel->addPost($title, $content);
    }

    private function checkUserPermission($userId, $postId) {
        $this->validateLogin();
        $postModel = new PostModel();
        $post = $postModel->getPost($postId);

        if ($userId != $post['user_id']) {
            header("Location: /pages/home.php");
            exit;
        }
    }



    public function editView() {
        $userModel = new UserModel();
        $userId = $userModel->getUserIdBySession($_SESSION['token']);
        $this->checkUserPermission($userId, $_GET['id']);

        $postModel = new PostModel();
        $post = $postModel->getPost($_GET['id']);

        if ($post) {
            ?>
                <form action="/api/updatePost.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                    <input type="text" name="title" value="<?php echo $post['title'] ?>">
                    <input type="text" name="description" value="<?php echo $post['description'] ?>">
                    <textarea name="content"><?php echo $post['content'] ?></textarea>
                    <input type="submit" value="Update Post">
                </form>
            <?php
        } else {
            echo "Post not found";
        }
    }
    
    public function updatePost() {
        $this->validateLogin();

        try {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $content = $_POST['content'];
            $id = $_POST['id'];

            $userModel = new UserModel();
            $userId = $userModel->getUserIdBySession($_SESSION['token']);

            $this->checkUserPermission($userId, $id);

            $postModel = new PostModel();
            $postModel->updatePost($id, $title, $description, $content);

            header("Location: /pages/post.php?id=".$id);
        } catch (Exception $e) {
            return "Please fill in all fields";
        }
    }
    
    public function deletePost() {
        $this->validateLogin();

        $userModel = new UserModel();
        $userId = $userModel->getUserIdBySession($_SESSION['token']);

        $this->checkUserPermission($userId, $_GET['id']);

        $postModel = new PostModel();
        $postModel->deletePost($_GET['id']);

        header("Location: /pages/home.php");
    }
    
}