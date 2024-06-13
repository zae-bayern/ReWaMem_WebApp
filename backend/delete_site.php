<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
  $siteId = $_POST['id'] ?? null;

  if ($siteId) {
      // Delete the site from the database
      $stmt = $db->prepare("DELETE FROM sites WHERE id = ? AND user_id = ?");
      if (!$stmt) {
          echo "Prepare failed: (" . $db->errno . ") " . $db->error;
          exit;
      }

      $stmt->bind_param("ii", $siteId, $userId);
      $success = $stmt->execute();

      if ($success) {
          echo "Seite erfolgreich gelöscht.";
      } else {
          echo "Fehler beim Löschen der Seite: " . $stmt->error;
      }

      $stmt->close();
  } else {
      echo "Ungültige Anfrage.";
  }
} else {
  echo "Unauthorized access.";
}
?>