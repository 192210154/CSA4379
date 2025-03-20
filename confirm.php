<?php
session_start();
include 'config.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: http://localhost/coastalhotel/login.php");
    exit;
}

if (isset($_GET['room_id'])) {
    $room_id = sanitize($_GET['room_id']);
    $check_in = sanitize($_GET['check_in']);
    $check_out = sanitize($_GET['check_out']);
    $sql = "SELECT * FROM rooms WHERE id = '$room_id'";
    $result = mysqli_query($conn, $sql);
    $room = mysqli_fetch_assoc($result);
    $price = $room['price'];
    $is_weekend = (new DateTime($check_in))->format('N') >= 5;
    if ($is_weekend) { $price *= 0.85; }
    $days = (strtotime($check_out) - strtotime($check_in)) / (60 * 60 * 24);
    $total = $price * $days;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['card_number'])) {
    $card_number = sanitize($_POST['card_number']);
    $expiry = sanitize($_POST['expiry']);
    $cvc = sanitize($_POST['cvc']);
    if ($card_number === '4242-4242-4242-4242' && strlen($expiry) == 5 && strlen($cvc) == 3) {
        $guest_name = sanitize($_POST['guest_name']);
        $email = sanitize($_POST['email']);
        $sql = "INSERT INTO bookings (room_id, check_in, check_out, guest_name, email, total) 
                VALUES ('$room_id', '$check_in', '$check_out', '$guest_name', '$email', '$total')";
        if (mysqli_query($conn, $sql)) {
            header("Location: save_booking.php?success=1&guest_name=" . urlencode($guest_name) . "&check_in=$check_in&check_out=$check_out");
            exit;
        } else {
            $error = "Booking failed: " . mysqli_error($conn);
        }
    } else {
        $error = "Invalid payment details! Use card: 4242-4242-4242-4242, any valid expiry (MM/YY), any 3-digit CVC.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Booking</title>
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
            <h1>Confirm Your Booking</h1>
        </div>
    </header>
    <div class="wave"></div>
    <section class="booking">
        <h2><?php echo $room['name']; ?></h2>
        <form action="confirm.php?room_id=<?php echo $room_id; ?>&check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out; ?>" method="POST">
            <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
            <input type="hidden" name="check_in" value="<?php echo $check_in; ?>">
            <input type="hidden" name="check_out" value="<?php echo $check_out; ?>">
            <label>Name: <input type="text" name="guest_name" required></label>
            <label>Email: <input type="email" name="email" required></label>
            <p>Total: $<?php echo number_format($total, 2); ?> <?php if ($is_weekend) echo '<span class="deal-text">(Weekend Deal Applied)</span>'; ?></p>
            <h3>Payment Details (Mock Card)</h3>
            <label>Card Number: <input type="text" name="card_number" placeholder="4242-4242-4242-4242" required></label>
            <label>Expiry (MM/YY): <input type="text" name="expiry" placeholder="12/25" required></label>
            <label>CVC: <input type="text" name="cvc" placeholder="123" required></label>
            <button type="submit">Pay & Confirm</button>
        </form>
        <h3>Or Pay with QR Code</h3>
        <p>Scan this QR code with your phone to pay $<?php echo number_format($total, 2); ?>:</p>
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://www.paypal.com/pay?amount=<?php echo $total; ?>" alt="QR Code Payment">
        <p>After payment, click <a href="save_booking.php?success=1&guest_name=Guest&check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out; ?>">here</a> to confirm booking manually.</p>
        <?php if (isset($error)) echo "<p class='deal-text'>$error</p>"; ?>
    </section>
    <footer>
        <p>Coastal Boutique Hotel © 2025</p>
        <p>Contact: info@coastalhotel.com | (123) 456-7890</p>
        <p><a href="http://localhost/coastalhotel/login.php">Login</a> | <a href="http://localhost/coastalhotel/register.php">Register</a> | <a href="http://localhost/coastalhotel/privacy.php">Privacy Policy</a> | <a href="http://localhost/coastalhotel/terms.php">Terms of Service</a></p>
    </footer>
</body>
</html>