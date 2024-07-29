<?php
session_start();
include('db_connect.php');
// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Return JSON response indicating successful logout
echo json_encode(['status' => 'success']);
?>