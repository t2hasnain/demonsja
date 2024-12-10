<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../includes/database.php";

// PHPMailer files
require_once "../PHPMailer/src/PHPMailer.php";
require_once "../PHPMailer/src/SMTP.php";
require_once "../PHPMailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require 'PHPMailer/src/PHPMailer.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $username_or_email = $_POST["username_or_email"];

    // Checks if username or email exists in the users table
    // $sql = "SELECT id, email, full_name FROM users WHERE email = ?";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("s", $username_or_email);
    $sql = "SELECT id, email, full_name FROM users WHERE email = ? OR full_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) 
    {
        $row = $result->fetch_assoc();
        $user_id = $row["id"];
        $user_email = $row["email"];
        $full_name = $row["full_name"]; //  to retrieve the full name from the database

        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Store the token and user ID in the password_reset table
        $sql = "INSERT INTO password_reset (user_id, token) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $token);
        $stmt->execute();

        // Send email with the reset link containing the token
        $reset_link = "http://indtube.rf.gd/password_reset/reset_password_page.php?token=$token";

        // Create a PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();                                       // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                  // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                              // Enable SMTP authentication
            $mail->Username   = 'YOUR_GMAIL';             // SMTP username
            $mail->Password   = 'GMAIL_PASSWORD';                // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;       // Enable implicit TLS encryption
            $mail->Port       = 465;                               // TCP port to connect to

            // Recipients
            $mail->setFrom('YOUR_GMAIL', 'INDTUBE');
            $mail->addAddress($user_email,$full_name);             // Add a recipient

            // Content
            $mail->isHTML(true);                                   // Set email format to HTML
            $mail->Subject = 'Password Reset INDTUBE';
            $mail->Body    = "Click the link to reset your password: <a href='$reset_link'>$reset_link</a>";

            // Send email
            $mail->send();
            echo "<br>Password reset link sent successfully."; // Response message
        } catch (Exception $e) {
            echo "Failed to send password reset email. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "User not found."; // Response message
    }
}
?>
