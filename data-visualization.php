<?php require_once ('header.php'); 
      require_once ('backend/db.php'); ?>

<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id'])) {
	// Redirect to the login page:
	header("Location: login.php");
	exit;
}

// Fetch user data from the database
$user_id = $_SESSION['user_id'];

// Get the site ID from the URL if it exists
$site_id = isset($_GET['site_id']) ? intval($_GET['site_id']) : null;

$sql = "SELECT id, username FROM users WHERE id = ?";
$stmt = $db->prepare($sql);
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

//Fetch site(s) data (for the current user only) from the database
$sql = "SELECT * FROM sites WHERE user_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$sites = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['site_data'] = json_decode($row['site_data'], true); 
        $sites[] = $row;
    }
} else {
    echo "No sites data found.";
    exit();
}

$stmt->close();

//Fetch consumption data only from all sites (to compare anonymously)
$sql = "SELECT * FROM sites WHERE user_id != ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$allsites = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['site_data'] = json_decode($row['site_data'], true);
        //anon
        $row['site_name'] = "";
        $row['user_id']   = "";

        $allsites[] = $row;
    }
} else {
    echo "No sites data found.";
    exit();
}

$stmt->close();

$allsitesJSON = json_encode($allsites);
$sitesJSON = json_encode($sites);
$userJSON = json_encode($user);
?>


<script>
	//Make data available to JS/HTML
	var userData = <?php echo $userJSON; ?>;
	var sitesData = <?php echo $sitesJSON; ?>;
    var allSitesData = <? echo $allsitesJSON; ?>;
</script>

<!-- TODO: calculate average value for each entries' timethingy  -->

<!--TODO: JS only interface with all visualization options, all sites data is already here -->
<!--
    <div id="data-display"></div>
    <div id="plotly-chart" style="width:100%;max-width:700px;height:500px;"></div>
-->
    <script src="3rdparty/plotly.min.js"></script>
    <script src="data-visualization.js"></script>

<div id="body-datavis" class="body-datavis">

    <div id="top-datavis">
        <button onclick="showContent('content1')">Option 1</button>
        <button onclick="showContent('content2')">Option 2</button>
        <button onclick="showContent('content3')">Option 3</button>
        <button onclick="showContent('content4')">Option 4</button>
    </div>

    <div id="bottom-datavis">
        <div id="content1" class="content-datavis">
            <h2>Content 1</h2>
            <p>This is some text content for option 1.</p>
            <table border="1">
                <tr>
                    <th>Header 1</th>
                    <th>Header 2</th>
                </tr>
                <tr>
                    <td>Data 1</td>
                    <td>Data 2</td>
                </tr>
            </table>
        </div>

        <div id="content2" class="content-datavis">
            <h2>Content 2</h2>
            <p>This is some text content for option 2.</p>
            <div id="plot1"></div>
            <script>
                var data = [{
                    x: [1, 2, 3, 4],
                    y: [10, 15, 13, 17],
                    type: 'scatter'
                }];
                Plotly.newPlot('plot1', data);
            </script>
        </div>

        <div id="content3" class="content-datavis">
            <h2>Content 3</h2>
            <p>This is some text content for option 3.</p>
        </div>

        <div id="content4" class="content-datavis">
            <h2>Content 4</h2>
            <p>This is some text content for option 4.</p>
            <div id="plot2"></div>
            <script>
                var data2 = [{
                    values: [19, 26, 55],
                    labels: ['Residential', 'Non-Residential', 'Utility'],
                    type: 'pie'
                }];
                Plotly.newPlot('plot2', data2);
            </script>
        </div>
    </div>

</div>


<?php require_once('footer.php');?>