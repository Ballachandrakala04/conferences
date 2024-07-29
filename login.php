<?php
session_start();
include('db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
     <title>Login Form2222</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mt-5">Login</h2>
            <?php if (!isset($_POST['submit'])) { ?>
            <form method="POST" onsubmit="login(); return false;">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Group</label>
                    <select class="form-select" id="group" name="group" required>
                        <option value="">Select a Group</option>
                        <option value="IHP NJ ER LLC">IHP NJ ER LLC</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <?php }; ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form data is set
    if (isset($_POST['username']) && isset($_POST['password'])) {
       // Get form data
        $user = $conn->real_escape_string($_POST['username']);
        $pass = $conn->real_escape_string($_POST['password']);
        $group = $_POST['group'];

        // Insert data into database
        $sql = "INSERT INTO users (`username`, `password`, `group`) VALUES ('$user', '$pass', '$group')";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Fetch user data
            $row = $result->fetch_assoc();
            
            // Assuming passwords are hashed using password_hash()
            if (password_verify($password, $row['password'])) {
                // Password is correct, set session variables and redirect
                $_SESSION['username'] = $username;
                header('Location: dashboard.php');
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with that username.";
        }

        if ($conn->query($sql) == TRUE) {
            echo "<script>alert('New record created successfully');</script>";
            // Redirect to another page (optional)
            echo "<script>window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
        }
         //if (!isset($_SESSION['username'])) {
           // header('Location: dashboard.php');
           // exit();
        //}

        $conn->close();
    } else {
        echo "<script>alert('Username or password is not set.');</script>";
    }
} else {
    echo "<script>alert('Invalid request method.');</script>";
}
?>
</body>
</html>
