<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: http://localhost/coastalhotel/index.html");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Coastal Boutique Hotel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <a href="http://localhost/coastalhotel/index.html">Home</a>
        <a href="http://localhost/coastalhotel/about.php">About Us</a>
        <a href="http://localhost/coastalhotel/gallery.php">Gallery</a>
        <a href="http://localhost/coastalhotel/contact.php">Contact</a>
        <a href="http://localhost/coastalhotel/my_bookings.php">My Bookings</a>
        <a href="http://localhost/coastalhotel/login.php">Login</a>
        <a href="http://localhost/coastalhotel/register.php">Register</a>
    </nav>
    <header>
        <div class="header-content">
            <h1>Login</h1>
        </div>
    </header>
    <div class="wave"></div>
    <section class="booking">
        <h2>Sign In</h2>
        <form action="login.php" method="POST">
            <label>Username: <input type="text" name="username" required></label>
            <label>Password: <input type="password" name="password" required></label>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error)) echo "<p class='deal-text'>$error</p>"; ?>
        <p>Don't have an account? <a href="http://localhost/coastalhotel/register.php">Register here</a>.</p>
    </section>
    <footer>
        <p>Coastal Boutique Hotel © 2025</p>
        <p>Contact: info@coastalhotel.com | (123) 456-7890</p>
        <p><a href="http://localhost/coastalhotel/login.php">Login</a> | <a href="http://localhost/coastalhotel/register.php">Register</a> | <a href="http://localhost/coastalhotel/privacy.php">Privacy Policy</a> | <a href="http://localhost/coastalhotel/terms.php">Terms of Service</a></p>
    </footer>
</body>
</html>