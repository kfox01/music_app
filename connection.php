<?php

// Database connection. Adjust parameters accordingly.
$host = 'localhost';
$db = 'music_db';
$user = 'root'; // Default XAMPP user
$pass = ''; // No password by default in XAMPP

$conn = new mysqli($host, $user, $pass, $db);

// Check for connection errors
if ($conn->connect_errno) {
  echo "Failed to connect to MySQL: " . $conn->connect_error;
  exit();
} else {
  echo "";
}
?>