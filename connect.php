<?php
$servername = "localhost";
$username = "root";
$password = "AZERTYUIOP@123456789";
$dbname = "education";
// $port=3308;               

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "";
?>