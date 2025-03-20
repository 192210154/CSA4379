<?php
session_start();
include 'config.php';
if (!isset($_SESSION['loggedin'])) { header("Location: login.php"); exit; }
$username = $_SESSION['username'];
if (isset($_GET['cancel'])) {
    $booking_id = $_GET['cancel'];
    $sql = "DELETE FROM bookings WHERE id = $booking_id AND email = (SELECT email FROM users WHERE username = '$username')";
    mysqli_query($conn, $sql);
    header("Location: dashboard.php");
}
$sql = "SELECT b.*, r.name FROM bookings b JOIN rooms r ON b.room_id = r.id WHERE b.email = (SELECT email FROM users WHERE username = '$username')";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <a href="index.html">Home</a>
        <a href="about.php">About Us</a>
        <a href="gallery.php">Gallery</a>
        <a href="contact.php">Contact</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </nav>
    <header>
        <div class="header-content">
            <h1>Welcome, <?php echo $username; ?></h1>
        </div>
    </header>
    <div class="wave"></div>
    <section class="booking">
        <h2>Your Bookings</h2>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <p><?php echo $row['name'] . ': ' . $row['check_in'] . ' to ' . $row['check_out'] . ' - $' . $row['total']; ?> 
               <a href="dashboard.php?cancel=<?php echo $row['id']; ?>" class="book-btn" style="background: #ff4500;">Cancel</a></p>
        <?php } ?>
        <a href="logout.php" class="book-btn">Logout</a>
    </section>
    <footer>
        <p>Coastal Boutique Hotel © 2025</p>
        <p>Contact: info@coastalhotel.com | (123) 456-7890</p>
    </footer>
</body>
</html>