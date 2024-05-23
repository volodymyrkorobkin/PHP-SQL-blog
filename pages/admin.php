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

            <form action="admin.php" method="post">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <button type="submit">Add user</button>
            </form>

        </section>
    </main>
</body>


<script>
    const form = document.querySelector("form");
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const username = formData.get("username");
        const password = formData.get("password");

        const response = await fetch("/api/addUser.php", {
            method: "POST",
            body: JSON.stringify({
                username,
                password
            })
        });

        const data = await response.json();
        console.log(data);

        // if (response.ok) {
        //     alert("User added");
        // } else {
        //     alert("Error adding user");
        // }

    });
</script>
</html>


