<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            position: relative;
        }

        #loginButton {
            display: none;
            position: absolute;
            top: 10px; 
            left: 50%; 
            transform: translateX(-50%) translateY(-65px); 
            background-color: yellow;
            color: black;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .container {
            margin-top: 100px;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
        }

        .card-body {
            padding: 40px;
        }

        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Reset Password</h3>
                    </div>
                    <div class="card-body">
                        <form id="resetForm" method="post">
                            <div class="mb-3">
                                <label for="username_or_email" class="form-label">Username or Email:</label>
                                <input type="text" id="username_or_email" name="username_or_email" class="form-control" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Reset Password</button>
                            </div>
                        </form>
                        <div id="message"><br></div> <!-- Message placeholder -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button id="loginButton" onclick="goToLoginPage()">Go to Login</button>

    <!-- JavaScript or AJAX code to handle form submission -->
    <script>
        function goToLoginPage() {
            window.location.href = "https://indtube.rf.gd/login.php";
        }

document.getElementById("resetForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission
    var formData = new FormData(this);

    // Send form data using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "reset_password.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) 
        {
            if (xhr.status == 200) 
            {
                document.getElementById("message").innerHTML = xhr.responseText; 
                document.querySelector('.mb-3').style.display = "none";
                document.querySelector('button[type="submit"]').style.display = "none"; 
                document.getElementById("loginButton").style.display = "block";
            } else
             {
                console.log("Error occurred.");
            }
        }
    };
    xhr.send(formData);
});


    </script>
</body>
</html>
