<?php
session_start();
include 'phpqrcode/qrlib.php'; // Include the QR code library

// Generate a unique token
$token = bin2hex(random_bytes(16));

// Store the token in the session or database
$_SESSION['qr_token'] = $token;

// Generate the QR code
QRcode::png('yourapp://login?token=' . $token, 'qrcode.png');

echo '<img src="qrcode.png" alt="QR Code">';
?>
