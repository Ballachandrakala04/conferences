<?php
session_start();
include('db_connect.php');
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
        $pdf = $_FILES['pdf']['tmp_name'];
        $pdfData = file_get_contents($pdf);

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO participants (`pdf`) VALUES (?)");
        $stmt->bind_param("b", $pdfData);

        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "No PDF uploaded or there was an error with the upload.";
    }
}
$conn->close();
?>
