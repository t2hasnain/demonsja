<?php

$hostName = "";
$dbUser = "";
$dbPassword = "";
$dbName = "";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) 
{
    die("Something went wrong;");
}

// Allowing only admins to register their account
$adminKey = password_hash("ADMIN_KEY_HERE", PASSWORD_DEFAULT); 

?>
