<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="https://img.icons8.com/color/96/video-playlist.png">


<!-- bootstrap  CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">


    <title> Admin Panel </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">




<style>
        body\
        {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container
        {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .user-info 
        {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .left-pane {
            width: 20%;
            top: 0;
            margin-top: 20px;
            height: 80vh;
            align-items: center;
            padding: 20px;
            background-color: #ffffff;
            border-right: 1px solid lightgrey; 
            position: sticky;
            top: 0;
        }

        .left-pane button
        {
            margin-bottom: 10px;
            background-color: #fff;
            border: 1px solid #000;
            border-radius: 50px;
            padding: 10px 20px;
            cursor: pointer;
            color: #000;
            transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
        }


        .left-pane button:hover
        {
            background-color: wheat;
            color: #000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .logout-btn
        {
            margin-top: auto;
            background-color: #fff;
            border: 1px solid #000;
            border-radius: 50px;
            padding: 10px 20px;
            cursor: pointer;
            color: #000;
            transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
            display: block;
            width: 70%;
            text-align: center;
            text-decoration: none;
        }

        .logout-btn:hover 
        {
            background-color: wheat;
            color: #000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }


        .right-pane {
            width: 75%;
            overflow-y: inherit; 
            background-color: #ffffff;
            padding: 20px 45px 20px; 
            margin-top: 20px; 
            position: relative; 
        }

        .video-table 
        {
            width: 75%;
            font-family: "Trebuchet MS", sans-serif;
            font-size: medium;
            background-color: lightblue;
            border-collapse: collapse;
            position: absolute; 
            top: 0; 
            margin-left: 400px;
            margin-top: -600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .video-table th, .video-table td 
        {
            padding: 10px;
            text-align: left;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd; 
        }

        .video-table th 
        {
            background-color: #f0f0f0;
        }

        .logout-link 
        {
            display: block;
            margin-top: 20px;
            text-align: right;
            text-decoration: none;
            color: #333;
        }

        .logout-link:hover 
        {
            color: #f00;
        }
    </style>




</head>
<body>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: ./login.php");
        exit();
    }

    require_once "includes/database.php";
    $userEmail = isset($_SESSION["email"]) ? $_SESSION["email"] : "";

    $userID = "";
    if (!empty($userEmail)) {
        $sql = "SELECT id FROM users WHERE email = '$userEmail'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $userID = $row['id'];
    }

    $message = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["jsonData"])) {
        $jsonData = json_decode($_POST["jsonData"], true);

        foreach ($jsonData as $rowData) {
            if (count($rowData)<5 || in_array(null,$rowData))
            {
                $message = "One or more column values are null.";
                break;
            }

            $category= $rowData[0];
            $title =$rowData[1];
            $link =$rowData[2];
            $section= $rowData[3];
            $subsection=$rowData[4];

            $sql ="INSERT INTO videos (category, title, link, section, subsection, user_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt =mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssii", $category, $title, $link, $section, $subsection, $userID);
                if (mysqli_stmt_execute($stmt)) 
                {
                    $message .= " Record inserted successfully.";
                } else 
                {
                    $message .= " Error inserting record: " . mysqli_error($conn);
                }
            } else 
            {
                $message .= " Error preparing statement: " . mysqli_error($conn);
            }
        }
    }

    $sql = "SELECT * FROM videos WHERE user_id = $userID";
    $result = mysqli_query($conn, $sql);
    ?>

<div class="container p-3 mt-3 mb-3 rounded" style="background-color: #f8f9fa; border: 1px solid #ced4da; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    <?php
    $sql1 = "SELECT full_name FROM users WHERE email = '$userEmail'";
    $result1 = mysqli_query($conn, $sql1);
    $row = mysqli_fetch_assoc($result1);
    $fullName = $row['full_name'];
    ?>
    <div style="background-color: #d4edda; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"><!-- Removed border styling -->
        <p style="font-size: 18px; font-weight: bold; color: #155724; margin: 0;">
            Welcome, <span style="font-style: italic; border-bottom: 1px solid #ced4da; color: #155724;"><?php echo htmlspecialchars($fullName); ?></span>
        </p>
    </div>
    <h3 class="text-center mb-4">Welcome to the Admin Dashboard!</h3>
</div>




<div class="col-md-3 left-pane">
    <h4>Actions</h4>
    
    <a href="https://indtube.rf.gd" class="btn btn-primary btn-light mt-3" style="background-color: #ffc107; border-color: #ffc107;" target="_blank"> Home</a><br><br>

    <button class="btn btn-primary" style="background-color: #cce5ff; border-color: #cce5ff;" onclick="document.getElementById('fileToUpload').click();">Upload File</button>
    <form id="uploadForm" action="index.php" method="post" enctype="multipart/form-data" style="display: none;">
        <input type="file" id="fileToUpload" accept=".xlsx" onchange="displayFileName()">
        <input type="hidden" id="jsonData" name="jsonData">
    </form>
    <p id="fileName"></p>
    <button class="btn btn-success mt-3" style="background-color: #d4edda; border-color: #d4edda;" onclick="processExcelData(); document.getElementById('uploadForm').submit();">Process File</button>
    <a href="./logout.php" class="btn btn-danger mt-3 logout-btn">Logout</a>
</div>







<div class="right-pane">
    <div class="video-table">
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th style='background-color: #ffc107;'>ID</th>";
            echo "<th style='background-color: #cce5ff;'>Category</th>";
            echo "<th style='background-color: #d4edda;'>Title</th>";
            echo "<th style='background-color: #f0f0f0;'>Link</th>";
            echo "<th style='background-color: #f8d7da;'>Section</th>";
            echo "<th style='background-color: #d6d8d9;'>Subsection</th>";
            echo "</tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['category'] . "</td>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['link'] . "</td>";
                echo "<td>" . $row['section'] . "</td>";
                echo "<td>" . $row['subsection'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No records found</p>";
        }
        ?>
    </div>
</div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script>
        function processExcelData() {
            var fileInput = document.getElementById('fileToUpload');
            var file = fileInput.files[0];
            var reader = new FileReader();

            reader.onload= function(e) {
                var data =new Uint8Array(e.target.result);
                var workbook= XLSX.read(data, { type: 'array' });
                var sheet =workbook.Sheets[workbook.SheetNames[0]];
                var jsonData =XLSX.utils.sheet_to_json(sheet, { header: 1 });

                var jsonDataString = JSON.stringify(jsonData);
                document.getElementById('jsonData').value = jsonDataString;

                document.getElementById('uploadForm').submit();
            };

            reader.readAsArrayBuffer(file);
        }

        function displayFileName()
        {
            var fileInput = document.getElementById('fileToUpload');
            var fileNameDisplay = document.getElementById('fileName');
            if (fileInput.files.length>0)
            {
                fileNameDisplay.textContent = 'Uploaded file: ' + fileInput.files[0].name;
            }
            else
            {
                fileNameDisplay.textContent ='';
            }
        }
    </script>
</body>
</html>
