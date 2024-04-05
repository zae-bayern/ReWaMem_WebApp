<?php

$host = 'localhost';  // MySQL host
$dbname = 'textildb'; // MySQL database
$username = 'root';   // MySQL username
$password = 'usbw';   // associated password

try {
  $db = new PDO('mysql:host=$host;dbname=$dbname', $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die("Database connection failed: " . $e->getMessage());
}  
?>