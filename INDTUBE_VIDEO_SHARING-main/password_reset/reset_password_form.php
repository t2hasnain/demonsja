<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <style>
        body 
        {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .input-group-addon {
            cursor: pointer;
        }
        .toggle-password {
            cursor: pointer;
        }
        #loginButton 
        {
            display: none;
            margin-top: 10px;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        #loginButton:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center mb-4">Reset Password</h1>
    <div class="mb-11">
        <form id="resetForm" method="post">
            <div class="form-group">
                <label for="new_password">New Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                    <div class="input-group-append">
                        <span class="input-group-text toggle-password">
                            <i class="ri-eye-off-fill icon"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    <div class="input-group-append">
                        <span class="input-group-text toggle-password">
                            <i class="ri-eye-off-fill icon"></i>
                        </span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
        </form>
    </div>
    <div id="message"></div> <!-- Message placeholder -->
    <button id="loginButton" onclick="goToLoginPage()">Go to Login</button>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
    // Toggle password visibility
    function togglePassword(inputId) 
    {
        var passwordInput = document.getElementById(inputId);
        var icon = document.querySelector('#' + inputId + ' + .input-group-append .icon');

        if (passwordInput.type === "password") 
        {
            passwordInput.type = "text";
            icon.classList.remove('ri-eye-off-fill');
            icon.classList.add('ri-eye-fill');
        } else {
            passwordInput.type = "password";
            icon.classList.remove('ri-eye-fill');
            icon.classList.add('ri-eye-off-fill');
        }
    }

    // Add onclick event to toggle password visibility for each eye icon
    document.querySelectorAll('.toggle-password').forEach(function(icon) 
    {
        icon.addEventListener('click', function() 
        {
            var inputId = this.parentElement.previousElementSibling.id;
            togglePassword(inputId);
        });
    });

    // AJAX form submission
    document.getElementById("resetForm").addEventListener("submit", function(event) 
    {
        event.preventDefault(); // Prevent default form submission
        var formData = new FormData(this);

        // Send form data using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "reset_password_handler.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    document.getElementById("message").innerHTML = xhr.responseText; 
                    document.querySelector('.mb-11').style.display = "none"; 
                    document.getElementById("loginButton").style.display = "block"; 
                } else {
                    console.log("Error occurred.");
                }
            }
        };
        xhr.send(formData);
    });

    function goToLoginPage()
    {
        window.location.href = "https://indtube.rf.gd/login.php";
    }
</script>


</body>
</html>
