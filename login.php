<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="login-card">
            <h2>Login</h2>
            <?php
    if(isset($_GET['registered']) && $_GET['registered'] == 'true') {
        echo "Registration successful. Please log in.";
    }

    if(isset($_GET['noUser']) && $_GET['noUser'] == 'true') {
        echo "There is no user with that username and password. Please register";
    }
?>
            <form action="login_process.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <input type="submit" value="Login">
            </form>
            <button onclick="location.href='register.php'" class="register-btn">Register</button>
            <button onclick="location.href='index.php'" class="home-btn">Return to store</button>
        </div>
    </div>
</body>
</html>