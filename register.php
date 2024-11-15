<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="container">
        <div class="register-card">
        <?php
    if(isset($_GET['alreadyexist']) && $_GET['alreadyexist'] == 'true') {
        echo "User already exists, please use another username and password";
    }
?>
            <h2>Register</h2>
            <form action="register_process.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <input type="submit" value="Register">
            </form>
            <button onclick="location.href='login.php'" class="login-btn">Login</button>
            <button onclick="location.href='index.php'" class="home-btn">Return to store</button>
        </div>
    </div>
</body>
</html>