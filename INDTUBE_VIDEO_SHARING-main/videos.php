<?php
require_once "includes/database.php";
require_once "includes/video_functions.php";

try {
    $sql = "SELECT * FROM videos ORDER BY section, subsection";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        throw new Exception("Error executing query: " . mysqli_error($conn));
    }

    $videos = mysqli_fetch_all($result, MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
    die(); //stops execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="https://img.icons8.com/color/96/video-playlist.png">

    <title>IndTube</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!--  remixicon CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="#">IndTube</a>
    </nav>
    <div class="container mt-4">
        <div class="d-flex justify-content-center mb-4">
            <button class="btn btn-primary mr-2 custom-button" onclick="window.location.reload();">Refresh</button>
            <button class="btn btn-secondary custom-button" onclick="window.location.href = 'login.php';">Admin Login</button>
        </div>

       <div class="row">
            <?php require_once "templates/video_card_template.php"; ?>
        </div>
    </div>

    <!--  bootstrap javaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
