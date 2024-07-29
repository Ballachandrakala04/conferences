<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin2"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //$search_name = $_POST['search_name'];
    //$search_room = $_POST['search_room'];
    //$search_date = $_POST['search_date'];
  }

$sql = "SELECT id, first_name, room, admission_date, charge_capture, facesheet FROM patients";

if (!empty($search_name)) {
    $sql .= " AND first_name LIKE '%$search_name%'";
  }
  if (!empty($search_room)) {
    $sql .= " AND room LIKE '%$search_room%'";
  }
  if (!empty($search_date)) {
    $sql .= " AND admission_date = '$search_date'";
  }
  
  $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
  <style>
    /* Custom styles */
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
    }

    /* Horizontal Navbar */
    .navbar-horizontal {
      background-color: #343a40;
      color: #fff;
      padding: 10px 20px;
    }

    .navbar-horizontal .navbar-brand {
      font-size: 1.5rem;
      font-weight: bold;
    }

    .navbar-horizontal .navbar-nav .nav-link {
      color: #fff;
      font-weight: bold;
      padding: 10px 15px;
      transition: background-color 0.3s;
    }

    .navbar-horizontal .navbar-nav .nav-link:hover {
      background-color: #495057;
    }

    /* Vertical Flipping Menu */
    .sidebar-flipping {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 194; /* Width of collapsed sidebar */
      background-color: #343a40;
      z-index: 1;
      overflow-y: auto;
      transition: width 0.3s ease;
    }

    .sidebar-flipping:hover {
      width: 250px; /* Expanded width of sidebar on hover */
    }

    .sidebar-flipping::-webkit-scrollbar {
      width: 8px;
    }

    .sidebar-flipping::-webkit-scrollbar-thumb {
      background-color: #6c757d;
      border-radius: 4px;
    }

    .sidebar-flipping .logo {
      padding: 10px;
      text-align: center;
      color: #fff;
      font-size: 1.8rem;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .sidebar-flipping ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    .sidebar-flipping ul li a {
      display: block;
      padding: 12px;
      text-align: center;
      text-decoration: none;
      color: #ced4da ! important;
      transition: background-color 0.3s;
    }

    .sidebar-flipping ul li a:hover {
      background-color: #574a49;
    }

    .sidebar-flipping ul li.active a {
      background-color: #adb5bd;
      color: #212529;
      font-weight: bold;
    }

    .sidebar-flipping ul li a .icon {
      margin-bottom: 5px;
      width: 24px;
      text-align: center;
    }

    /* Main content */
    .content-wrapper {
      margin-left: 80px; /* Width of collapsed sidebar */
      transition: margin-left 0.3s ease;
    }

    .content {
      padding: 20px;
    }
   
    /* Hover Effects */
    .sidebar-flipping ul li a:hover .icon,
    .navbar-horizontal .navbar-nav .nav-link:hover {
      color: #ffc107; /* Yellow */
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .sidebar-flipping {
        width: 250px; /* Expanded width of sidebar on small screens */
      }

      .content-wrapper {
        margin-left: 250px; /* Width of expanded sidebar on small screens */
      }
    }
  </style>
</head>
<body>
  <!-- Horizontal Navbar -->
  <nav class="navbar navbar-expand-lg navbar-horizontal">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"></a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link"  data-page="notifications" href="#"><i class="fas fa-bell"></i> Notifications</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-page="messages" href="#"><i class="fas fa-envelope"></i> Messages</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-page="logout" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  data-page="upload" href="#"><i class="fas fa-cloud-upload-alt"></i> Upload</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Wrapper -->
  <div class="wrapper">

    <!-- Vertical Flipping Menu -->
    <nav class="sidebar-flipping">
      <div class="logo">Charge Capture</div>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#" data-page="profile">
            <span class="icon"><i class="fas fa-tachometer-alt"></i></span>
            Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-page="PatientsList">
            <span class="icon"><i class="fas fa-shopping-cart"></i></span>
           My Patients List
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-page="pendingbilling">
            <span class="icon"><i class="fas fa-box"></i></span>
          Pending Billing
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-page="settings">
            <span class="icon"><i class="fas fa-cog"></i></span>
            Settings
          </a>
        </li>
      <!-- This is a comment<li class="nav-item">
          <a class="nav-link" href="#">
            <span class="icon"><i class="fas fa-users"></i></span>
            Customers
          </a>
        </li>
       <li class="nav-item">
          <a class="nav-link" href="#">
            <span class="icon"><i class="fas fa-chart-bar"></i></span>
            Reports
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <span class="icon"><i class="fas fa-cog"></i></span>
            Settings
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <span class="icon"><i class="fas fa-question-circle"></i></span>
            Help
          </a>
        </li> -->
      </ul>
    </nav>
 <div class="content" id="content">
  <div class="container">
    <div class="row justify-content-center mt-5">
    
      <div class="col-lg-9">
      <div id="dashboard">
        <!-- Custom Box -->
        <div class="custom-box">
          <h2>Choose the Facility</h2>
                   <button class="btn btn-primary assisted">MASONIC HOME (Assisted Living)</button>
        </div>
      </div>
      <div class="col-md-4"></div>
   <div class="col-lg-12" style="display:none;" id="patientpopup">
   <h2>Patient Information Form</h2>
   <?php if (!isset($_POST['creat'])) { ?>
    <form action="process.php" method="POST">
      <div class="mb-3">
        <label for="lastName" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="lastName" name="lastName" required>
      </div>
      <div class="mb-3">
        <label for="firstName" class="form-label">First Name</label>
        <input type="text" class="form-control" id="firstName" name="firstName" required>
      </div>
      <div class="mb-3">
        <label for="dob" class="form-label">Date of Birth</label>
        <input type="date" class="form-control" id="dob" name="dob" required>
      </div>
      <div class="mb-3">
        <label for="mrn" class="form-label">Medical Record Number (MRN)</label>
        <input type="text" class="form-control" id="mrn" name="mrn" required>
      </div>
      <button type="creat" class="btn btn-primary">Create</button>
    </form>
    <?php }?>
  </div>

 <div class="col-lg-12">
  <div id="residentlist" style="display:none;">
     <!-- Custom Box -->
        <div class="custom-box">
          <h2>Patient Data</h2>
          <button class="btn btn-primary btn-custom mb-2 d-flex justify-content-center mt-2 patients-form">Add Patients</button><br/>
          <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Room</th>
          <th>Admission Date</th>
          <th>Charge Capture</th>
          <th>Facesheet</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
          // Output data of each row
          while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"]. "</td>
                    <td>" . $row["first_name"]. "</td>
                    <td>" . $row["room"]. "</td>
                    <td>" . $row["admission_date"]. "</td>
                    <td>" . $row["charge_capture"]. "</td>
                    <td>" . $row["facesheet"]. "</td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='6'>No records found</td></tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
        </div>
      </div>
  </div>

    </div>
  </div>
    </div>


  <script>
$(document).ready(function() {
    // Handle click on vertical navigation links
    $('.nav-link').on('click', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        loadPage(page);
    });

    // Handle click on horizontal navigation links
    $('.nav-item').on('click', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        loadPage(page);
    });

    $('.assisted').on('click', function(e) {alert("test");
        e.preventDefault();
        $('#dashboard').css('display','none');
        $('#residentlist').css('display','block');
    });

    $('.patients-form').on('click', function(e) {alert("test2");
        e.preventDefault();
        $('#dashboard').css('display','none');
        $('#residentlist').css('display','none');
        $('#patientpopup').css('display','block');
    });
 

    // Function to load page via AJAX
    function loadPage(page) {
        $.ajax({
            url: 'load_page.php', // URL of the server-side script to load content
            type: 'POST', // Use POST method to send data
            data: { page: page }, // Send page identifier to server
            success: function(response) {
                $('#content').html(response); // Replace content of #content with loaded page
            },
            error: function(xhr, status, error) {
                console.error('Error loading page: ' + status + ', ' + error);
                // Handle errors if necessary
            }
        });
    }

    // Load default page (e.g., Dashboard) on page load
    //loadPage('dashboard');
});

    </script>
    <style>
  .custom-box {
      background-color: #f8f9fa;
      padding: 60px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    .custom-box h2 {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
      position: relative;
      display: inline-block;
    }
    .custom-box h2::before {
      content: "";
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 50px;
      height: 2px;
      background-color: #007bff; /* Adjust underline color */
    }
    .custom-box p {
      font-size: 16px;
      line-height: 1.6;
      margin-bottom: 20px;
    }
    .custom-box button {
      font-size: 16px;
      padding: 10px 20px;
    }

  </style>
 </body>
</html>
