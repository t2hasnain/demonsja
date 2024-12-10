<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["token"])) 
{
    $token = $_GET["token"];

    // Checks if the token exists in the password_reset table and is valid (not expired)
    require_once "../includes/database.php";

    $sql = "SELECT user_id FROM password_reset WHERE token = ? AND created_at >= NOW() - INTERVAL 1 HOUR";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Token is valid, allow the user to reset their password
        $_SESSION["token"] = $token;
        header("Location: ./reset_password_form.php");
        exit();
    } else 
    {
        echo "Invalid or expired token.";
    }
} else {
    echo "Token not provided.";
}
?>
