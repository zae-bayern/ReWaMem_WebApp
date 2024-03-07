<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $stmt = $db->prepare("SELECT * FROM sites WHERE user_id = ?");
    $stmt->execute([$userId]);
    $sites = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($sites);
} else {
    // Handle unauthorized access
    echo "Unauthorized access.";
}
?>
