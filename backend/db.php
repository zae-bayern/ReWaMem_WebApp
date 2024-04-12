<?php

$host = 'localhost';  // MySQL host
$dbname = 'textildb'; // MySQL database
$username = 'root';   // MySQL username
$password = 'usbw';   // associated password

$db = new mysqli($host, $username, $password, $dbname);

if ($db->connection_error) {
  die("Database connection failed: " . $db->connect_error);
}  
?>