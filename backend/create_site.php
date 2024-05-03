<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $siteName = $_POST['name'] ?? $userId . time();

    // Form fields from "datenerfassung.php"
    $data = [
        'company' => $_POST['company'] ?? '',
        'type' => $_POST['type'] ?? '',
        'org' => $_POST['org'] ?? [0],
        'contact' => $_POST['contact'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'email' => $_POST['email'] ?? '',
        'year' => $_POST['year'] ?? '',
        'month' => $_POST['month'] ?? '',
        'day' => $_POST['day'] ?? '',
        'work' => $_POST['work'] ?? [],
        'trockenwaesche' => $_POST['trockenwaesche'] ?? '',
        'berufskleidung' => $_POST['berufskleidung'] ?? '',
        'krankenhaus' => $_POST['krankenhaus'] ?? '',
        'hotel' => $_POST['hotel'] ?? '',
        'bewohner' => $_POST['bewohner'] ?? '',
        'handtuch' => $_POST['handtuch'] ?? '',
        'fussmatten' => $_POST['fussmatten'] ?? '',
        'feuchtwisch' => $_POST['feuchtwisch'] ?? '',
        'reinigungsteile' => $_POST['reinigungsteile'] ?? '',
        'sonstiges' => $_POST['sonstiges'] ?? '',
        'wasser' => $_POST['wasser'] ?? '',
        'strom' => $_POST['strom'] ?? '',
        'oel' => $_POST['oel'] ?? '',
        'gas' => $_POST['gas'] ?? '',
        'holz' => $_POST['holz'] ?? '',
        'sonstigeenergie' => $_POST['sonstigeenergie'] ?? '',
        'waschmittel' => $_POST['waschmittel'] ?? '',
        'abwasserandere' => $_POST['abwasserandere'] ?? ''
    ];

    $siteData = json_encode($data);

    // Prepare the MySQLi SQL insert statement
    $stmt = $db->prepare("INSERT INTO sites (user_id, site_name, site_data) VALUES (?, ?, ?)");
    if (!$stmt) {
        echo "Prepare failed: (" . $db->errno . ") " . $db->error;
        exit;
    }

    // Bind parameters
    $stmt->bind_param("iss", $userId, $siteName, $siteData);
    $success = $stmt->execute();

    if ($success) {
        echo "Site created successfully.";
    } else {
        echo "Error creating site: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Handle unauthorized access or wrong request method
    echo "Unauthorized access.";
}
?>