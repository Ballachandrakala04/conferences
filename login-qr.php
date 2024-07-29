<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form id="loginForm">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="button" id="loginBtn" class="btn btn-primary">Login</button>
            <button type="button" id="qrBtn" class="btn btn-secondary">Login with QR Code</button>
        </form>
        <div id="qrCodeContainer" style="display:none;">
            <h3>Scan this QR Code with your mobile app:</h3>
            <div id="qrCode"></div>
        </div>
    </div>

    <script>
        $('#loginBtn').click(function() {
            var username = $('#username').val();
            var password = $('#password').val();

            $.ajax({
                url: 'login-qr.php',
                type: 'POST',
                data: {username: username, password: password},
                success: function(response) {
                    if(response.success) {
                        window.location.href = 'login-qr.php';
                    } else {
                        alert(response.message);
                    }
                }
            });
        });

        $('#qrBtn').click(function() {
            $.ajax({
                url: 'generate_qr.php',
                type: 'GET',
                success: function(response) {
                    $('#qrCode').html(response);
                    $('#qrCodeContainer').show();
                }
            });
        });
    </script>
</body>
</html>
