<?php
ob_start();
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $organization = $_POST['organization'];
    $telephone = $_POST['telephone'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $interestedin = $_POST['interestedin'];
    $billingaddress = $_POST['billingaddress'];
    $participants = $_POST['participants'];
    #$email = $_POST['email'];

    $participantType = $_POST['participant_type'];
    $accommodation = isset($_POST['accommodation']) ? implode(', ', $_POST['accommodation']) : 'None';

    // Calculate total price based on participant type and accommodation
    $totalPrice = 0;
    switch ($participantType) {
        case 'Academic':
            $totalPrice = 499;
            break;
        case 'Industry':
            $totalPrice = 599;
            break;
        case 'Delegate':
            $totalPrice = 399;
            break;
        case 'Student':
            $totalPrice = 299;
            break;
        case 'Virtual':
            $totalPrice = 199;
            break;
        default:
            $totalPrice = 0;
    }

    // Process payment (simulate success for demonstration)
    $paymentStatus = true; // Replace with actual payment processing logic

    if ($paymentStatus) {
        // Payment successful, save participant data to database
        // Insert into database or save to a file, etc.
        // Example: Saving to database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "admin2";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO participants (title, name, email, organization, telephone, city, country, interestedin, billingaddress, 
        participanttype, accommodation, totalprice)
       VALUES ('$title', '$name', '$email', '$organization', '$telephone', '$city', '$country', '$interestedin', 
       '$billingaddress','$participantType', '$accommodation', '$totalPrice')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

        echo "Payment successful. Participant data saved.";
    } else {
        echo "Payment failed. Please try again.";
    }
}
?>


