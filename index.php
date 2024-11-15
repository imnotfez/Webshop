<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $item = array(
        'name' => $name,
        'price' => $price,
        'image' => $image,
        'quantity' => 1,
        'total_price' => $price
    );

    // If the cart doesn't exist, create it
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Add the item to the cart
    array_push($_SESSION['cart'], $item);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voideba</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="header.css">
</head>
<body>
    <?php require "header.php"; ?>
    <div class="container">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "nedgameopdracht";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT platform, genre, sort, availability, medium, region, developer, price, age, name, description, afbeelding FROM games";

        $stmt = $conn->query($sql);

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="card">';
                echo '<h3>' . $row["name"] . '</h3>';
                echo "<img src='imgs/{$row['afbeelding']}' alt='' class='card-img'>";
                echo "<p><strong>Platform:</strong> "  . $row["platform"] . "</p>";
                echo "<p><strong>Developer:</strong> " . $row["developer"] . "</p>";
                echo "<p><strong>Price:</strong> $" . $row["price"] . "</p>";
                echo "<p><strong>Age:</strong> " . $row["age"] . "</p>";
                echo "<p><strong>Description:</strong> " . $row["description"] . "</p>";
                echo "<form method='POST' action=''>";
                echo "<input type='hidden' name='name' value='{$row['name']}'>";
                echo "<input type='hidden' name='price' value='{$row['price']}'>";
                echo "<input type='hidden' name='image' value='{$row['afbeelding']}'>";
                echo "<button type='submit' class='add-to-cart'> Add to cart </button>";
                echo "</form>";
                echo '</div>';
            }
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>
    </div>
    <script src="script.js"></script>
</body>
</html>