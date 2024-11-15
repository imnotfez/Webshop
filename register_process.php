<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if($password != $confirm_password) {
            echo "Passwords do not match.";
            exit;
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Database connection
        $servername = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "nedgameopdracht";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the username already exists
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if($user) {
                header('Location: register.php?alreadyexist=true');
                exit;
            }

            // Insert the new user into the database
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $hashed_password]);

            header('Location: login.php?registered=true');
            exit;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>