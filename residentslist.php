

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient Data</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2>Patient Data</h2>
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
  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>