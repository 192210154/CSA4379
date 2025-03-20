<?php
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";
    mysqli_query($conn, $sql);
    $success = "Message sent!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact - Coastal Boutique Hotel</title>
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
            <h1>Contact Us</h1>
        </div>
    </header>
    <div class="wave"></div>
    <section class="booking">
        <h2>Get in Touch</h2>
        <form action="contact.php" method="POST">
            <label>Name: <input type="text" name="name" required></label>
            <label>Email: <input type="email" name="email" required></label>
            <label>Message: <textarea name="message" required></textarea></label>
            <button type="submit">Send</button>
        </form>
        <?php if (isset($success)) echo "<p class='deal-text'>$success</p>"; ?>
        <p>Location: 123 Coastal Lane (Map placeholder)</p>
    </section>
    <footer>
        <p>Coastal Boutique Hotel © 2025</p>
        <p>Contact: info@coastalhotel.com | (123) 456-7890</p>
    </footer>
</body>
</html>