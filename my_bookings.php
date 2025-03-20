<?php
session_start();
include 'config.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: http://localhost/coastalhotel/login.php");
    exit;
}

$username = $_SESSION['username'];
$sql = "SELECT b.*, r.name FROM bookings b 
        JOIN rooms r ON b.room_id = r.id 
        WHERE b.email = (SELECT email FROM users WHERE username = '$username')";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings - Coastal Boutique Hotel</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .booking-table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .booking-table th, .booking-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .booking-table th {
            background: #00ced1;
            color: white;
            font-size: 1.2em;
        }
        .booking-table tr:hover {
            background: #f5f5f5;
        }
        .no-bookings {
            text-align: center;
            padding: 20px;
            font-style: italic;
        }
    </style>
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
            <h1>My Bookings</h1>
            <p>Welcome, <?php echo $username; ?>!</p>
        </div>
    </header>
    <div class="wave"></div>
    <section class="booking">
        <h2>Your Upcoming Stays</h2>
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='booking-table'>";
            echo "<tr><th>Room</th><th>Check-In</th><th>Check-Out</th><th>Total Cost</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['check_in'] . "</td>";
                echo "<td>" . $row['check_out'] . "</td>";
                echo "<td>$" . number_format($row['total'], 2) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-bookings'>No bookings yet! <a href='http://localhost/coastalhotel/index.html'>Book now</a>.</p>";
        }
        ?>
        <a href="http://localhost/coastalhotel/logout.php" class="book-btn">Logout</a>
    </section>
    <footer>
        <p>Coastal Boutique Hotel © 2025</p>
        <p>Contact: info@coastalhotel.com | (123) 456-7890</p>
        <p><a href="http://localhost/coastalhotel/login.php">Login</a> | <a href="http://localhost/coastalhotel/register.php">Register</a> | <a href="http://localhost/coastalhotel/privacy.php">Privacy Policy</a> | <a href="http://localhost/coastalhotel/terms.php">Terms of Service</a></p>
    </footer>
</body>
</html>