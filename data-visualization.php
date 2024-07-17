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

<!--TODO: JS only interface with all visualization options, all sites data is already here -->
<!--
    <div id="data-display"></div>
    <div id="plotly-chart" style="width:100%;max-width:700px;height:500px;"></div>
-->
    <script src="3rdparty/plotly.min.js"></script>
    <script src="data-visualization.js"></script>

<div id="body-datavis" class="body-datavis">

<!-- TODO: Add dropdown to select from multiple sites (if any)
       AND add which one to show as site parameter -->

    <div id="top-datavis">
        <button onclick="showContent('content1')">Option 1</button>
        <button onclick="showContent('content2')">Option 2</button>
        <button onclick="showContent('content3')">Option 3</button>
        <button onclick="showContent('content4')">Option 4</button>
    </div>

    <div id="bottom-datavis" style="width: 100%;">
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

        <div id="content2" class="content-datavis" style="width: 100%;">
            <h2>Content 2</h2>
            <p>This is some text content for option 2.</p>
            <div id="plot2" style="width: 100%;"></div>
            <script>
                var data2 = [{
                    x: [1, 2, 3, 4],
                    y: [10, 15, 13, 17],
                    type: 'scatter'
                }];

                var plotContainer = document.getElementById('bottom-datavis');
                var containerWidth = plotContainer.clientWidth;
                var containerHeight = plotContainer.clientHeight * 0.75;

                var layout2 = {
                    title: 'Title 2',
                    font: {size: 16},
                    width: containerWidth,
                    height: containerHeight
                };

                var config2 = {responsive: true, displaylogo: false};

                Plotly.newPlot('plot2', data2, layout2, config2);
            </script>
        </div>

        <div id="content3" class="content-datavis">
            <h2>Content 3</h2>
            <p>This is some text content for option 3.</p>
        </div>

        <div id="content4" class="content-datavis" style="width: 100%;">
            <h2>Content 4</h2>
            <p>This is some text content for option 4.</p>
            <div id="plot4" style="width: 100%;"></div>
            <script>
                var trace = {type: 'bar',
                    x: [1, 2, 3, 4],
                    y: [5, 10, 2, 8],
                    marker: {
                        color: '#C8A2C8',
                        line: {
                            width: 2.5
                        }
                }};

                var data4 = [ trace ];

                var plotContainer = document.getElementById('bottom-datavis');
                var containerWidth = plotContainer.clientWidth;
                var containerHeight = plotContainer.clientHeight * 0.75;

                var layout4 = {
                    title: 'Title 4',
                    font: {size: 16},
                    width: containerWidth,
                    height: containerHeight
                };

                var config4 = {responsive: true, displaylogo: false};

                Plotly.newPlot('plot4', data4, layout4, config4);
            </script>
            <script>
                // Add an event listener to update the plot size on window resize
                window.addEventListener('resize', function() {
                    var plotContainer = document.getElementById('bottom-datavis');
                    var newWidth = plotContainer.clientWidth;
                    var newHeight = plotContainer.clientHeight * 0.75;
                    Plotly.relayout('plot2', { width: newWidth, height: newHeight });
                    Plotly.relayout('plot4', { width: newWidth, height: newHeight });
                });
            </script>
        </div>
    </div>

</div>


<?php require_once('footer.php');?>