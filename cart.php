<?php
session_start();

if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    if ($_SESSION['cart'][$index]['quantity'] > 1) {
        $_SESSION['cart'][$index]['quantity']--;
        $_SESSION['cart'][$index]['total_price'] = $_SESSION['cart'][$index]['price'] * $_SESSION['cart'][$index]['quantity'];
    } else {
        unset($_SESSION['cart'][$index]);
    }
    header("Location: cart.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['increase'];
    $_SESSION['cart'][$index]['quantity']++;
    $_SESSION['cart'][$index]['total_price'] = $_SESSION['cart'][$index]['quantity'] * $_SESSION['cart'][$index]['price'];
    header('Location: cart.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <?php require "headercart.php"; ?>
    <h1 class='numItems'>Your Shopping Cart</h1>
    <?php
            if (isset($_SESSION['cart'])) {
                $numItems = 0;
                foreach ($_SESSION['cart'] as $item) {
                    $numItems += $item['quantity'];
                }
                echo "<h1 class='numItems'> There are $numItems item(s) in the cart. </h1>";
            } 

            echo "<form method='POST' action='checkout.php'>";
            echo "<input type='submit' value='Purchase'>";
            echo "</form>";
        ?>
    <?php
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "Your cart is empty.";
        echo "<br></br>";
        echo "Please add products that you wish to buy at the home screen.";
    } else {
        foreach ($_SESSION['cart'] as $index => $item) {
            echo "<div class='cart-div'>"; 
            echo "<img src='imgs/" . $item['image'] . "' alt=''>";
            echo "<h2>" . $item['name'] . "</h2>";
            echo "<p> Amount: " . (isset($item['quantity']) ? $item['quantity'] : 0) . "</p>";
            echo "<p>Total Price: $" . (isset($item['total_price']) ? $item['total_price'] : $item['price']) . "</p>";
            echo "<a href='cart.php?remove=$index'>Remove a item?</a>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='increase' value='$index'>";
            echo "<input type='submit' value='Add another item?'>";
            echo "</form>";
            echo "</div>";
        }
    }
    ?>
</body>
</html>