<?php
session_start();
include 'config.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: http://localhost/coastalhotel/index.html");
    exit;
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $guest_name = urldecode($_GET['guest_name']);
    $check_in = $_GET['check_in'];
    $check_out = $_GET['check_out'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmed</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <a href="http://localhost/coastalhotel/index.html">Home</a>
        <a href="http://localhost/coastalhotel/about.php">About Us</a>
        <a href="http://localhost/coastalhotel/gallery.php">Gallery</a>
        <a href="http://localhost/coastalhotel/contact.php">Contact</a>
        <a href="http://localhost/coastalhotel/my_bookings.php">My Bookings</a>
        <a href="http://localhost/coastalhotel/logout.php">Logout</a>
    </nav>
    <header>
        <div class="header-content">
            <h1>Booking Confirmed!</h1>
        </div>
    </header>
    <div class="wave"></div>
    <section class="booking">
        <p>Ahoy, <?php echo $guest_name; ?>! Your stay is booked from <?php echo $check_in; ?> to <?php echo $check_out; ?>.</p>
        <p>Payment successful (mock). Check your email for confirmation.</p>
        <a href="http://localhost/coastalhotel/index.html" class="book-btn">Back to Home</a>
    </section>
    <footer>
        <p>Coastal Boutique Hotel © 2025</p>
        <p>Contact: info@coastalhotel.com | (123) 456-7890</p>
        <p><a href="http://localhost/coastalhotel/login.php">Login</a> | <a href="http://localhost/coastalhotel/register.php">Register</a> | <a href="http://localhost/coastalhotel/privacy.php">Privacy Policy</a> | <a href="http://localhost/coastalhotel/terms.php">Terms of Service</a></p>
    </footer>
</body>
</html>
<?php
} else {
    header("Location: http://localhost/coastalhotel/index.html");
    exit;
}
?>