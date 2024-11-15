<?php
session_start();

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

}

$totalCost = 0;
$cartItems = [];
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $totalCost += $item['total_price'];
        $cartItems[] = $item;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
    <?php require "headercart.php"; ?>
    <h1>Checkout</h1>
    <?php
    if (isset($_SESSION['username'])) {
        echo "<p>Welcome, " . $_SESSION['username'] . "</p>";
    }
    echo "<p>Total cost: $" . $totalCost . "</p>";

    if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['email'])) {
        $email = $_POST["email"];
        $orderNumber = mt_rand(100000, 999999);
        echo "<p>Thank you for shopping! Your order has been sent to " . htmlspecialchars($email) . ".</p>";
        echo "<p>Order Number: " . $orderNumber . "</p>";
        if (!empty($cartItems)) {
            echo "<h2>Items you ordered:</h2>";
            echo "<ul>";
            foreach ($cartItems as $item) {
                echo "<li>";
                echo "<img src='imgs/" . $item['image'] . "' alt='" . $item['name'] . "'>";
                echo $item['name'] . " - $" . $item['total_price'];
                        $to = $email;
        $subject = "Order Confirmation";
        $message = "Thank you for shopping with us!";
        $messagetwo = " Your order number is " . $orderNumber;
        $messagethree = "You have ordered " . $item['name'] . " - $" . $item['total_price'];
        $headers = "From:Redeba Games";
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $gameKey = '';
        $gameKey2 = '';
        $gameKey3 = '';
        for ($i = 0; $i < 6; $i++) {
            $gameKey .= $characters[mt_rand(0, strlen($characters) - 1)];
            $gameKey2 .= $characters[mt_rand(0, strlen($characters) - 1)];
            $gameKey3 .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 
            $mail->isSMTP();                                      
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;                               
            $mail->Username = 'mrfezvoid@gmail.com';                 
            $mail->Password = 'cbxqknycvrzxkiuk';                           
            $mail->SMTPSecure = 'tls';                            
            $mail->Port = 587;                                    
        
            //Recipients
            $mail->setFrom('mrfezvoid@gmail.com', 'Redeba Games');
            $mail->addAddress($email, 'Redeba Games'); 
            
            // Attach the game image
            $mail->addEmbeddedImage('imgs/' . $item['image'], 'game_image');
        
            //Content
            $mail->isHTML(true);                                  
            $mail->Subject = $subject;
            $mail->Body    = "
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                    }
                    .email-container {
                        width: 80%;
                        margin: auto;
                        padding: 20px;
                        background-color: #f7f7f7;
                        border-radius: 5px;
                    }
                    .header {
                        text-align: center;
                        color: #4CAF50;
                    }
                    .content {
                        margin-top: 20px;
                    }
                    .footer {
                        margin-top: 30px;
                        text-align: center;
                        color: #888;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <h1 class='header'>Thank You for Your Order!</h1>
                    <div class='content'>
                        <p>Dear Customer,</p>
                        <p>Thank you for shopping with us. Your order number is " . $orderNumber . ".</p>
                        <p>You have ordered " . $item['name'] . " - $" . $item['total_price'] . ".</p>
                        <p>Game Key: " . $gameKey .  "-" . $gameKey2 . "-" . $gameKey3 . ".</p>
                        <img src='cid:game_image' alt='" . $item['name'] . "'>
                    </div>
                    <div class='footer'>
                        <p>Best regards,</p>
                        <p>The Redeba Games Team</p>
                    </div>
                </div>
            </body>
            </html>";

        
            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

                echo "</li>";
            }
            echo "</ul>";
        }
    } else {
        if (!empty($cartItems)) {
            echo "<h2>Your Cart</h2>";
            echo "<form method='post' action=''>";
            echo "<ul>";
            foreach ($cartItems as $item) {
                echo "<li>";
                echo "<img src='imgs/" . $item['image'] . "' alt='" . $item['name'] . "'>";
                echo $item['name'] . " - $" . $item['total_price'];
                echo "</li>";
            }
            echo "</ul>";
            echo "<label for='email'>Email:</label>";
            echo "<input type='email' id='email' name='email' required>";
            echo "<p>Select a purchase method:</p>";
            echo "<input type='radio' id='paypal' name='payment' value='paypal' required>";
            echo "<label for='paypal'>PayPal</label><br>";
            echo "<input type='radio' id='banking' name='payment' value='banking'>";
            echo "<label for='banking'>Banking</label><br>";
            echo "<input type='radio' id='crypto' name='payment' value='crypto'>";
            echo "<label for='crypto'>Crypto</label><br>";
            echo "<input type='submit' value='Submit'>";
            echo "</form>";
        } else {
            echo "<p>Your cart is empty.</p>";
        }
    }
    ?>
</body>
</html>