<?php
$conn = new mysqli("127.0.0.1","root","deepak@123","rentre");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
$login_url = '/login.php';
$salt = '6690';

?>
