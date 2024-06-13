<header>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <?php 
            include_once "../controllers/userController.php";
            $userController = new UserController();
            if (isset($_SESSION['token']) && $userController->isUserAdmin()) {
                echo "<li><a href='admin.php'>Admin</a></li>";
            }
            ?>
        </ul>
    </nav>
</header>