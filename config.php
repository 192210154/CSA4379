<?php
$conn = mysqli_connect('localhost', 'root', '', 'hotel_db');
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars($data));
}
?>