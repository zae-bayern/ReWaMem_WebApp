<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Prepare the MySQLi SQL select statement
    $stmt = $db->prepare("SELECT * FROM sites WHERE user_id = ?");
    if ($stmt === false) {
        die('MySQL prepare error: ' . $db->error);
    }

    // Bind the integer parameter for the user ID
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    // Get the result of the query
    $result = $stmt->get_result();
    $sites = [];

    // Fetch associative array
    while ($row = $result->fetch_assoc()) {
        $sites[] = $row;
    }

    $stmt->close();

    // Send result back as JSON
    header('Content-Type: application/json');
    echo json_encode($sites);
} else {
    // Handle unauthorized access
    echo "Unauthorized access.";
}
?>
