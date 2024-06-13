<?php
include_once "../controllers/userController.php";
include_once "../models/userModel.php"; 
$userController = new UserController();
if (!$userController->validateLogin()) {
    header("Location: login.php");
    exit;
}

if (!$userController->isUserAdmin()) {
    header("Location: home.php");
    exit;
}

if (isset($_POST['username'])) {
    $userController->addUser();
}

include_once "../php/header.php";
?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <main>
        <section>
            <h2>Add user</h2>

            <form action="" method="post">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <button type="submit">Add user</button>
            </form>

        </section>
        <section>
            <h2>Add posts</h2>

            <form action="/api/addPost.php" method="post">
                <input type="text" name="title" placeholder="Title">
                <input type="text" name="description" placeholder="Description">
                <textarea name="content" placeholder="Content"></textarea>
                <input type="submit" value="Add Post">
            </form>
        </section>


        <section>
            <h2>Users</h2>

            <?php

            $userModel = new UserModel();
            $users = $userModel->getUsers();

            if ($users) {
                foreach ($users as $user) {
                    ?>
                    <h3><?php echo $user['username'] ?></h3>
                    <a href="/api/deleteUser.php?id=<?php echo $user['id'] ?>">Delete</a>
                    <?php
                }
            } else {
                echo "No users found";
            }



            ?>
        </section>
    </main>
</body>
</html>


