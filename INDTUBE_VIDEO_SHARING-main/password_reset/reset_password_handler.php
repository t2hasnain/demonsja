<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["token"]) && isset($_POST["new_password"]))
{
    $token = $_SESSION["token"];
    $new_password = $_POST["new_password"];

    require_once "../includes/database.php";

    $sql = "UPDATE users u
            JOIN password_reset pr ON u.id = pr.user_id
            SET u.password = ?
            WHERE pr.token = ?";
    $stmt = $conn->prepare($sql);
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt->bind_param("ss", $hashed_password, $token);
    $stmt->execute();

    // Delete the token from the password_reset table
    $sql = "DELETE FROM password_reset WHERE token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();

    echo "Password reset successfully.";
} else {
    echo "Invalid request.";
}
?>
