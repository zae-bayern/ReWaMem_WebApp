<?php require_once('header.php');?>

<?php
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page:
    header("Location: login.php");
    exit;
}

// Fetch user data from the database
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No user data found.";
    exit();
}

$stmt->close();

//Fetch sites data for all users from the database
$sql = "SELECT site_data FROM sites";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
	$sites = $result->fetch_assoc();
} else {
	echo "No sites data found.";
	exit();
}

$stmt->close();
$conn->close();

//Make data available in JS/HTML
$sitesProc = array_map(function($site) {
	$site['site_data'] = json_decode($site['site_data'], true);
	return $site;
}, $sites);

$sitesJSON = json_encode($sitesProc);
$userJSON = json_encode($user);
?>


<script>
	//Make data available to JS/HTML
	var userData = <?php echo $userJSON; ?>;
	var sitesData = <?php echo $sitesJSON; ?>;
</script>



<!--TODO: JS only interface with all visualization options, all sites data is already here -->

    <div id="data-display"></div>
    <div id="plotly-chart" style="width:100%;max-width:700px;height:500px;"></div>

    <script src="data-visualization.js"></script>
<?php require_once('footer.php');?>