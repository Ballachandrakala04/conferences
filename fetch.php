<?php
session_start();
include('db_connect.php');
$sql = "SELECT pdf_file FROM participants ORDER BY id DESC LIMIT 2";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo base64_encode($row['pdf_file']);
} else {
    echo "No PDF found.";
}
?>