<?php
session_start();

$token = json_decode(file_get_contents('php://input'))->token;

if ($token === $_SESSION['qr_token']) {
    $_SESSION['user'] = 'some_user';
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
