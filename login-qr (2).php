<?php
session_start();
include 'db_connect.php'; // Database connection

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username = ? AND password = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['user'] = $username;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
}
?>
