<?php
    // Start a session
    session_start();

    // Check if form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Database connection
        $servername = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "nedgameopdracht";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Retrieve the user from the database
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            // Check if the user exists and the password is correct
            if($user && password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['username'] = $username;
                $_SESSION['logged_in'] = true;

                // Redirect to index.php
                header('Location: index.php');
                exit;
            } else {
                header('Location: login.php?noUser=true');
                exit;
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>