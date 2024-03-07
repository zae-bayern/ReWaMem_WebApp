<?php

$host = 'localhost';
$dbname = 'your_db';
$username = '';
$password = '';

try {
  $db = new PDO('mysql:host=$host;dbname=$dbname', $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die("Database connection failed: " . $e->getMessage());
}  
?>