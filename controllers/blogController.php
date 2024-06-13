<?php
include_once "../controllers/controller.php";
include_once "../models/postModel.php";

class BlogController {
    public function viewPosts($page) {
        $postModel = new PostModel();
        $data = $postModel->getPosts($page, 6);

        $posts = $data['posts'];
        $totalPages = $data['totalPages'];
        
        if ($posts) {
            foreach ($posts as $post) {
                ?>
                <a href="post.php?id=<?php echo $post['id']; ?>">
                    <h1><?php echo $post["title"] ?></h1>
                </a>
                <h3><?php echo $post["description"] ?></h3>
                <p>Posted on: <?php echo $post['created_on'] ?></p>

                <?php
            }
            ?>
                <br>
                <h4>Pages:</h4>
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a href='home.php?page=$i'>$i</a>";
                echo " ";
            }

        } else {
            echo "No posts found";  
        }

        ?>
        <?php
    }
}