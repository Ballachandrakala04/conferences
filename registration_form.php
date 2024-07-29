<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .form-select,
        .form-control {
            border-radius: 5px;
        }
        .btn {
            border-radius: 5px;
        }
        .card-radio input[type="radio"] {
            display: none;
        }
        .card-radio label {
            cursor: pointer;
            transition: all 0.3s;
        }
        .card-radio input[type="radio"]:checked + label {
            border-color: #007bff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
        }

    </style>
<body>
<div class="container mt-5 mb-5">
    <h2>Advaced Registration Form</h2>
    <form id="registrationForm">
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
            <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
        </div>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
        </div>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-building"></i></span>
            <input type="text" class="form-control" id="organization" name="organization" placeholder="Organization" required>
        </div>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
            <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Telephone" required>
        </div>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
            <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
        </div>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-flag-fill"></i></span>
            <select class="form-select" id="country" name="country" required>
                <option selected disabled>Select country</option>
                <option value="USA">USA</option>
                <option value="Canada">Canada</option>
                <!-- Add more countries as needed -->
            </select>
        </div>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-star-fill"></i></span>
            <select class="form-select" id="interestedin" name="interestedin" required>
                <option selected disabled>Select option</option>
                <option value="Poster Presentation">Poster Presentation</option>
                <!-- Add more options as needed -->
            </select>
        </div>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-house-fill"></i></span>
            <input type="text" class="form-control" id="billingaddress" name="billingaddress" placeholder="Billing Address" required>
        </div>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-people-fill"></i></span>
            <select class="form-select" id="participants" name="participants" required>
                <option selected disabled>Select option</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <!-- Add more options as needed -->
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Early bird - NOVEMBER 06</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="participant_type" id="academic" value="Academic">
                <label class="form-check-label" for="academic">
                    Academic - $499
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="participant_type" id="industry" value="Industry">
                <label class="form-check-label" for="industry">
                    Industry - $599
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="participant_type" id="delegate" value="Delegate">
                <label class="form-check-label" for="delegate">
                    Delegate - $399
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="participant_type" id="student" value="Student">
                <label class="form-check-label" for="student">
                    Student - $299
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="participant_type" id="virtual" value="Virtual">
                <label class="form-check-label" for="virtual">
                    Virtual - $199
                </label>
            </div>

            <div class="mb-3">
            <label class="form-label">Accommodation</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="singleOccupancy" name="accommodation[]" value="Single Occupancy">
                <label class="form-check-label" for="singleOccupancy">
                    Single Occupancy
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="doubleOccupancy" name="accommodation[]" value="Double Occupancy">
                <label class="form-check-label" for="doubleOccupancy">
                    Double Occupancy
                </label>
            </div>
        </div>

        </div>
 <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Pay</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="button" class="btn btn-danger" id="logout">Logout</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#registrationForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'submit_form.php',
                data: $(this).serialize(),
                success: function(response) {
                    alert(response);
                }
            });
        });

        $('#logout').on('click', function() {
            window.location.href = 'login.php';
        });
    });
</script>
</body>
</html>
