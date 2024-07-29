<?php
// load_page.php

if (isset($_POST['page'])) {
    $page = $_POST['page'];

    // Example: Load different pages based on $page value
    switch ($page) {
        case 'dashboard':
            include 'pages/dashboard.php'; // Path to your dashboard content
            break;
        case 'users':
            include 'pages/index.php'; // Path to your users content
            break;
        case 'settings':
            include 'pages/residentslist.php'; // Path to your settings content
            break;
         default:
            echo 'Page not found';
    }
} else {
    echo 'Invalid request';
}
?>
