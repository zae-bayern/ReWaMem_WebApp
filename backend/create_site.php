<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $siteName = $_POST['site_name'];
    $siteData = $_POST['site_data']; // Assuming this is a JSON string or similar TODO

    $stmt = $db->prepare("INSERT INTO sites (user_id, site_name, site_data) VALUES (?, ?, ?)");
    $success = $stmt->execute([$userId, $siteName, $siteData]);

    if ($success) {
        echo "Site created successfully.";
    } else {
        echo "Error creating site.";
    }
} else {
    // Handle unauthorized access or wrong request method
    echo "Unauthorized access.";
}
?>
