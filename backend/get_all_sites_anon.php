<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['user_id'])) {
  $sql = "SELECT site_name, data FROM sites";
  $stmt = $db->prepare($sql);
  if (!$stmt) {
    echo "Prepare failed: (" . $db->errno . ") " . $db->error;
    exit;
  }

  $stmt->execute();
  $result = $stmt->get_result();

  $results = [];
  while ($row = $result->fetch_assoc()) {
    $results[] = $row;
  }

  $stmt->close();

  header('Content-Type: application/json');
  echo json_encode($results);
}
else {
  echo "Unauthorized access.";
}
?>

<?php
/*
function fetchDataAndDisplay() {
    fetch('get_all_sites_anon.php')
        .then(response => response.json())
        .then(sites => {
            sites.forEach(site => {
                const siteData = JSON.parse(site.data); // Parse the JSON data
                // Now you can use siteData as an object, e.g., siteData.views, siteData.sales
                
                // Example: Displaying data
                document.getElementById('data-display').innerHTML += `<p>${site.site_name}: Views - ${siteData.views}, Sales - ${siteData.sales}</p>`;

                // If plotting, you would collect these data points and then plot them as shown in previous examples
            });

            // If you were collecting data for plotting, the plot function call would go here
        })
        .catch(error => console.error('Error fetching data:', error));
}
*/
?>
