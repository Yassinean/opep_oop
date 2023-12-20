<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <header class="">
        <nav class="container">
            <a href="index.php">
                <img src="../images/logo.png" alt="Logo" class="logo">
            </a>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="./blog.php">Blog</a></li>
                <li><a href="./article.php">Article</a></li>

            </ul>
        </nav>
        <div class="form containerx">
            <?php
            if (isset($_SESSION["client"])) {
                echo '<form action="../Includes/logout.inc.php" method="post">
                <button type="submit" name="logout-submit">Logout</button>
                <a class="cart-shopping" href="../pages/cart.php">card <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i></a>

            </form>';
            } else {
                echo '<form action="../includes/login.inc.php" method="post">
                <input type="text" name="userId" placeholder="Username/Email...">
                <input type="password" name="password" placeholder="Enter your password">
                <button type="submit" name="login-submit">Login</button>
            </form>
            <a href="signup.php">Sign Up</a>';
            }
            ?>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
            <script src="your_existing_script.js"></script>

        </div>
    </header>