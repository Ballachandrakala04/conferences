<?php
//  error_reporting(E_ALL);
// ini_set("display_errors", "1");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Data from Database</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/smoothness/jquery-ui.css">
    <style>
        /* Optional: Add some basic styling */
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<form id="uploadForm" enctype="multipart/form-data">
     <input type="file" name="pdf" id="pdf" accept="application/pdf required">
        <button type="submit" class="bg-dark py-2 px-2 text-white">Submit</button>
    </form>
    <div id="response"></div>
    <div id="pdfDisplay"></div>

 <?php
session_start();

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     Capture other form fields
//     $title = $_POST['title'];
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $organization = $_POST['organization'];
//     $telephone = $_POST['telephone'];
//     $city = $_POST['city'];
//     $country = $_POST['country'];
//     $interestedIn = $_POST['interestedIn'];
//     $billingaddress = $_POST['billingaddress'];
//     $totalprice = $_POST['totalprice'];

//     // Handle file upload
//     if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
//         $pdf = $_FILES['pdf']['tmp_name'];
//         $pdfData = file_get_contents($pdf);

//         // Prepare SQL statement
//         $stmt = $conn->prepare("INSERT INTO participants (pdf_file) VALUES (?)");
//         $stmt->bind_param("s", $pdfData);

//         if ($stmt->execute()) {
//             echo "New record created successfully";
//         } else {
//             echo "Error: " . $stmt->error;
//         }
        
//         $stmt->close();
//     } else {
//         echo "No PDF uploaded or there was an error with the upload.";
//     }
// }?> 



<div class="container col-md-12">
<p class="text-white-500 text-5xl bg-blue-500 p-2 md:bg-green-500 md:bg-red-500">Participant Data</p>

     <input type="text" id="searchInput" class="form-control" placeholder="Search for names.." aria-label="Search" aria-describedby="search-icon" oninput="search()">
    <table id="participantTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Account Number</th>
                <th>PDF FILE</th>
                <th>Title</th>
                <th>Name</th>
                <th>Email</th>
                <th>Organization</th>
                <th>Telephone</th>
                <th>City</th>
                <th>Country</th>
                <th>Interested In</th>
                <th>Billing Address</th>
                <th>Participant TYPE</th>
                <th>Accomadation</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
        <?php
// Include database connection
include 'db_connect.php';


// SQL query to fetch data from participants table
$sql = "SELECT * FROM participants";
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Initialize an empty array to store data
    $data = array();

    // Fetch data from each row and add it to $data array
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"]. "</td>
                 <td>" . $row["account_number"]. "</td>
                 <td>". $row["pdf_file"]. "</td>
                <td>" . $row["title"]. "</td>
                <td>" . $row["name"]. "</td>
                <td>" . $row["email"]. "</td>
                <td>" . $row["organization"]. "</td>
                 <td>" . $row["telephone"]. "</td>
                <td>" . $row["city"]. "</td>
                <td>" . $row["country"]. "</td>
                <td>" . $row["interestedIn"]. "</td>
                <td>" . $row["billingaddress"]. "</td>
                <td>" .$row["participanttype"]. "</td>
                <td>" . $row["accommodation"]. "</td>
                 <td>" . $row["totalprice"]. "</td>
                
              </tr>";
      }
    }  else {
    // If no results found, return an empty JSON array
    echo json_encode([]);
}

// Close connection
$conn->close();
?>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            // AJAX request to fetch data from fetch_data.php
            $.ajax({
                url: 'fetch_data.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Iterate through each object in the JSON array
                    $.each(response, function(index, data) {
                        // Append table rows with fetched data
                        $('#participantTable tbody').append(
                            '<tr>' +
                            '<td>' + data.title + '</td>' +
                            '<td>' + data.pdf_file + '</td>' +
                            '<td>' + data.name + '</td>' +
                            '<td>' + data.email + '</td>' +
                            '<td>' + data.organization + '</td>' +
                            '<td>' + data.telephone + '</td>' +
                            '<td>' + data.city + '</td>' +
                            '<td>' + data.country + '</td>' +
                            '<td>' + data.interestedIn + '</td>' +
                            '<td>' + data.billingaddress + '</td>' +
                            '<td>' + data.participanttype + '</td>' +
                            '<td>' + data.accommodation + '</td>' +
                            '<td>' + data.totalprice + '</td>' +
                            '</tr>'
                        );
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data: ' + status + ' - ' + error);
                }    
                
            });

            $('#uploadForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: 'upload.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#response').html(response);
                        fetchPDF();
                    }
                });
            });

            function fetchPDF() {
                $.ajax({
                    url: 'fetch.php',
                    type: 'GET',
                    success: function(data) {
                        var pdfWindow = window.open("");
                        pdfWindow.document.write("<iframe width='100%' height='100%' src='data:application/pdf;base64," + data + "'></iframe>");
                    }
                });
            }
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#participantTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            function searchAccount() {
            var accountNumber = $('#searchInput').val();
            if (accountNumber.length > 0) {
                $.ajax({
                    url: 'fetch_data.php',
                    type: 'POST',
                    data: { accountNumber: accountNumber },
                    success: function(response) {
                        $('#result').html(response);
                    }
                });
            } else {
                $('#result').html('');
            }
        }




        });
    </script>
    <script>
        let typingTimer;
        const typingInterval = 300;
    function search() {
      const query = document.getElementById('search').value;
      if (query.length > 0) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "search.php?q=" + query, true);
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('results').innerHTML = xhr.responseText;
          }
        };
        xhr.send();
      } else {
        document.getElementById('results').innerHTML = '';
      }
    }
  </script>
  </div>
</body>
</html>
