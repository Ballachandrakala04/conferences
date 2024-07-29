<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // Collect form data
  $lastName = $_POST["lastName"];
  $firstName = $_POST["firstName"];
  $dob = $_POST["dob"];
  $mrn = $_POST["mrn"];
  
  // Database connection parameters
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "admin2";
  
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  // Prepare SQL statement to insert data into database

  $sqlpatients_form = "INSERT INTO patients_form (`lastName`, `firstName`, `dob`, `mrn`)
          VALUES (?, ?, ?, ?)";
  
  // Prepare and bind parameters
  $stmt = $conn->prepare($sqlpatients_form);
  $stmt->bind_param("ssss", $lastName, $firstName, $dob, $mrn);
  
  // Execute SQL statement
  if ($stmt->execute()) {
    echo "New record patients_form created successfully";
  } else {
    echo "Error: " . $sqlpatients_form . "<br>" . $conn->error;
  }
  
  // Close statement and connection
  $stmtp->close();
  $conn->close();
}
?>
