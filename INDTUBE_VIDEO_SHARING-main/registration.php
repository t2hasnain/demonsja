<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Admin Registration </title>
    <link rel="icon" type="image/png" sizes="128x128" href="https://img.icons8.com/stickers/100/test-account.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/stylereg.css">

</head>
<body>
    <div class="container">
        <form action="registration.php" class="login__Form" method="post">
            <h1 class="login__title">Register</h1>
            <?php
            require_once "includes/database.php";

            if (isset($_POST["submit"])) 
            {
                $fullName = $_POST["fullname"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $passwordRepeat = $_POST["repeat_password"];
                $adminKeyInput = $_POST["admin_key"]; 

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $errors = array();
                if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat) OR empty($adminKeyInput)) {
                    array_push($errors, "All fields are required");
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email is not valid");
                }

                // it checks password length condtion
                if (strlen($password) < 8) {
                    array_push($errors, "Password must be at least 8 characters long");
                }

                // confirm password matching
                if ($password !== $passwordRepeat) {
                    array_push($errors, "Password does not match");
                }

                // Verify admin key so that only admins can create account
                if (!password_verify($adminKeyInput, $adminKey)) {
                    array_push($errors, "Invalid Admin key");
                }

                // Check if there are any errors
                if (count($errors) > 0) {
                    foreach ($errors as  $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    // Inserts user data into the database
                    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
                    $stmt =mysqli_stmt_init($conn);
                    $prepareStmt= mysqli_stmt_prepare($stmt, $sql);
                    if ($prepareStmt) {
                        mysqli_stmt_bind_param($stmt,"sss",$fullName,$email, $passwordHash);
                        mysqli_stmt_execute($stmt);
                        echo "<div class='alert alert-success'>You are registered successfully.</div>";
                    }
                    else
                    {
                        die("Something went wrong");
                    }
                }
            }
            ?>
            <div class="login__inputs">
                <div class="form-group">
                    <input type="text" class="form-control" name="fullname" placeholder=" Full Name" required>
                </div>

                <div class="form-group">
                    <div style="position:relative;">
                        <input type="email" class="form-control" name="email" placeholder="Email" style="padding-right: 40px;" required>
                        <i class="ri-mail-fill icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required id="registerPassword1">
                    <i class="ri-eye-fill password-toggle icon" onclick="togglePassword('registerPassword1')"></i>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="repeat_password" placeholder="Confirm Password" required id="registerPassword2">
                    <i class="ri-eye-fill password-toggle icon" onclick="togglePassword('registerPassword2')"></i>
                </div>
                
                <div class="form-group">
                    <input type="password" class="form-control" name="admin_key" id="adminKeyInput" placeholder="Authentication Key" required>
                    <i class="ri-eye-fill password-toggle icon" onclick="togglePassword('adminKeyInput')"></i>
                </div>
                <br>

                <div class="form-btn">
                    <input type="submit" class="login__button" value="Register" name="submit">
                </div>

            </div>
        </form>
    </div>
    <div class="login__register"><p>Already Registered ? <a href="login.php">Login Here</a></p></div>
    <script src="js/scriptreg.js"></script>

</body>
</html>
