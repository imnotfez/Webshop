<header>
    <div class="logo">
        <img src="imgs/voideba.png" alt="Logo">
        <h1 >Voideba</h1>
    </div>
    <div class="actions">
    <?php
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            echo "<p class='username'>Welcome, " . $_SESSION['username'] . "</p>";
}
    ?>
        <a href="cart.php">
            <button class="shopping-cart">Shopping Cart <span id="cartNumber"></span></button>
        </a>
        <a href="index.php">
            <button class="home">Home</button>
        </a>
        <?php
            if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                echo '<button class="loginregister" onclick="window.location.href=\'logout.php\'">Logout</button>';
            } else {
                echo '<button class="loginregister" onclick="window.location.href=\'login.php\'">Login / Register</button>';
            }
        ?>
    </div>
</header>