<?php
session_start();
include('db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Account</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/smoothness/jquery-ui.css">
</head>
<body>
    <div class="container mt-5">
        <!-- <h1>Search Account</h1> -->
        <form id="searchForm">
            <div class="mb-3">
                <label for="accountNumber" class="form-label">Account Number</label>
                <input type="text" class="form-control" id="accountNumber" name="accountNumber" required  oninput="searchAccount()">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <div id="result" class="mt-3"></div>
    </div>
    <script>
        $(document).ready(function() {
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'fetch_data.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#result').html(response);
                    }
                });
            });

            function searchAccount() {
            var accountNumber = $('#accountNumber').val();
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

</body>
    </html>