<?php
session_start();
include 'config.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: http://localhost/coastalhotel/index.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $check_in = sanitize($_POST['check_in']);
    $check_out = sanitize($_POST['check_out']);
    $sql = "SELECT * FROM rooms WHERE id NOT IN (
        SELECT room_id FROM bookings 
        WHERE (check_in <= '$check_out' AND check_out >= '$check_in')
    )";
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Rooms</title>
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
            <h1>Available Rooms</h1>
            <p><?php echo $check_in . ' to ' . $check_out; ?></p>
        </div>
    </header>
    <div class="wave"></div>
    <section class="rooms">
        <div class="room-grid">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $price = $row['price'];
            $start = new DateTime($check_in);
            $end = new DateTime($check_out);
            $is_weekend = ($start->format('N') >= 5 || $end->format('N') <= 7);
            if ($is_weekend) { $price *= 0.85; }
            $img = strtolower(str_replace('’', '', str_replace(' ', '-', $row['name']))) . '.jpg';
        ?>
            <div class="room">
                <img src="images/<?php echo $img; ?>" alt="<?php echo $row['name']; ?>">
                <h3><?php echo $row['name']; ?></h3>
                <p>$<?php echo number_format($price, 2); ?>/night <?php if ($is_weekend) echo '<span class="deal-text">(15% off)</span>'; ?></p>
                <a href="confirm.php?room_id=<?php echo $row['id']; ?>&check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out; ?>" class="book-btn">Book Now</a>
            </div>
        <?php } ?>
        </div>
    </section>
    <footer>
        <p>Coastal Boutique Hotel © 2025</p>
        <p>Contact: info@coastalhotel.com | (123) 456-7890</p>
        <p><a href="http://localhost/coastalhotel/login.php">Login</a> | <a href="http://localhost/coastalhotel/register.php">Register</a> | <a href="http://localhost/coastalhotel/privacy.php">Privacy Policy</a> | <a href="http://localhost/coastalhotel/terms.php">Terms of Service</a></p>
    </footer>
</body>
</html>
<?php } ?>