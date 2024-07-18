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
    var allSitesData = <?php echo $allsitesJSON; ?>;
</script>

<!--TODO: JS only interface with all visualization options, all sites data is already here -->
    <script src="3rdparty/plotly.min.js"></script>
    <script src="data-visualization.js"></script>

<div id="body-datavis" class="body-datavis">

<!-- TODO: Add dropdown to select from multiple sites (if any)
       AND add which one to show as site parameter -->

    <label for="siteSelect">Betrieb wählen:</label>
    <select id="siteSelect">
        <!-- Options are added with js right below -->
    </select>

    <script>
        const dropdown = document.getElementById("siteSelect");
        dropdown.innerHTML = '';

        //TODO: generate these from sitesData
        const options = [
            {value: '1', text: 'CHMS/ReWaMem Teststand'},
            {value: '2', text: 'Testbetrieb'}
        ];

        options.forEach(option => {
                const opt = document.createElement('option');
                opt.value = option.value;
                opt.textContent = option.text;
                dropdown.appendChild(opt);
            });

        //TODO: Add handlers to change plots/data when a option is chosen
        dropdown.addEventListener('change', function() {
            const selectedValue = dropdown.value;
            console.log('Selected value:', selectedValue);

            // TODO: Add the code you want to execute when a different option is chosen
            // For example, you could call a function to update plots or data:
            //updateDataBasedOnSelection(selectedValue);
        });

    </script>

    <hr style="margin-top:20px; border: none; border-top: 1px solid #000; width: 63%;">

    <div id="top-datavis">
        <button onclick="showContent('content1')" style="height:56px;">Auswertung in Zahlen</button> 
        <button onclick="showContent('content2')" style="height:56px;">Grafische Auswertung</button> 
        <button onclick="showContent('content3')" style="height:56px;">Vergleich Verbräuche</button> 
        <button onclick="showContent('content4')" style="height:56px;">Sonderauswertung</button>
    </div>

    <div id="bottom-datavis" style="width: 100%;">
        <div id="content1" class="content-datavis">
            <h2>Auswertung in Zahlen</h2>
            <p>Betriebsdaten im Branchenvergleich zum Minimal-, Maximal-, und Durchschnittswert.</p>
            <table border="1" style="table-layout: fixed; margin: 0 auto; margin-top: 8%;">
                <tr>
                    <th style="width: 5%; padding: 6px;"></th>
                    <th style="width: 5%; padding: 6px;">Mein Betrieb</th>
                    <th style="width: 5%; padding: 6px;">Minimaler Wert</th>
                    <th style="width: 5%; padding: 6px;">Maximaler Wert</th>
                    <th style="width: 5%; padding: 6px;">Durchschnitt</th>
                </tr>
<!--TODO: fill these in from data with js -->
                <tr>
                    <td>Wasser [l]</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Strom [kWh]</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>therm. Energie [kWh]</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Waschmittel [g]</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
<!-- TODO: Ersparnis durch Nanofiltration aus Daten generieren -->
 <div style="margin-top:3%; display:flex; align-items:center;">
    <p style="margin-left:50%; font-size: 12px;">Mögliche Einsparung von Wasser durch den Einsatz von Nanofiltration: bis zu <span id="nanofilt_sav">0.0</span> L. <br> <a href="https://www.rewamem.de/">Mehr Informationen.</a> </p>
 </div>

            <div style="margin-top: 14%; width: 90%; display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                <p style="margin: 0; margin-left: 6%;">* Gegenüberstellung der einzelnen Betriebsdaten im Vergleich zum Schnitt der Branche bezogen auf 1kg Wäsche.</p>
                <hr style="flex-grow: 1; margin: 0 10px; border: none;">
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="width: 20px; height: 20px; background-color: red;"></span>
                        <span>Dringender Handlungsbedarf</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="width: 20px; height: 20px; background-color: yellow;"></span>
                        <span>Verbesserung möglich</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="width: 20px; height: 20px; background-color: green;"></span>
                        <span>Stand der Technik</span>
                    </div>
                </div>
            </div>

        </div>

        <div id="content2" class="content-datavis" style="width: 100%;">
            <h2>Grafische Auswertung</h2>
            <p>Grafische Datenauswertung nach Verbräuchen von Wasser, Strom [kWh], thermischer Energie [kWh], und Waschmittel.</p>
            <div id="plot2" style="width: 100%;"></div>
            <script>
                // Define the data points for different types
                var trace1 = {
                    x: [1, 2, 3, 4, 5],
                    y: [10, 15, 13, 17, 10],
                    mode: 'markers',
                    type: 'scatter',
                    name: 'Type 1',
                    marker: { size: 12, symbol: 'circle', color: 'red' }
                };

                var trace2 = {
                    x: [2, 3, 4, 5, 6],
                    y: [16, 5, 11, 9, 15],
                    mode: 'markers',
                    type: 'scatter',
                    name: 'Type 2',
                    marker: { size: 12, symbol: 'square', color: 'blue' }
                };

                var trace3 = {
                    x: [1, 2, 3, 4, 5],
                    y: [12, 9, 15, 12, 14],
                    mode: 'markers',
                    type: 'scatter',
                    name: 'Type 3',
                    marker: { size: 12, symbol: 'diamond', color: 'green' }
                };

                var data2 = [trace1, trace2, trace3];

                var plotContainer = document.getElementById('bottom-datavis');
                var containerWidth = plotContainer.clientWidth;
                var containerHeight = plotContainer.clientHeight * 0.75;

                var layout2 = {
                    title: 'Title 2',
                    font: { size: 16, color: document.documentElement.getAttribute('data-theme') === 'dark' ? 'white' : 'black' },
                    paper_bgcolor: document.documentElement.getAttribute('data-theme') === 'dark' ? '#2c2c2c' : 'white',
                    plot_bgcolor: document.documentElement.getAttribute('data-theme') === 'dark' ? '#2c2c2c' : 'white',
                    width: containerWidth,
                    height: containerHeight
                };

                var config2 = {responsive: true, displaylogo: false};

                Plotly.newPlot('plot2', data2, layout2, config2);
            </script>
        </div>

        <div id="content3" class="content-datavis">
            <h2>Vergleich Verbräuche</h2>
            <p>Die Verbräuche des eigenen Betriebs von Wasser, Strom [kWh], thermischer Energie [kWh], und Waschmittel im Vergleich mit angezeigter Waschmenge und Verarbeitungsschwerpunkt.</p>
        </div>

        <div id="content4" class="content-datavis" style="width: 100%;">
            <h2>Sonderauswertung</h2>
            <p>Grafische Datenauswertung nach Verbräuchen von Wasser, Strom [kWh], thermischer Energie [kWh], und Waschmittel. Der Branchenvergleich kann hier gesondert nach Art der Wäsche gefiltert durchgeführt werden.</p>
            <div id="plot4" style="width: 100%;"></div>
            <script>
                var xValues = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
                var yValues = [5, 10, 2, 8, 7, 3, 9, 12, 4, 6];
                
                var trace = {
                    type: 'bar',
                    x: xValues,
                    y: yValues,
                    marker: {
                        color: '#C8A2C8',
                        line: {
                            width: 2.5
                        }
                    }
                };

                //calculate statistics

                var average = yValues.reduce((a, b) => a + b, 0) / yValues.length;
                var plus15Percent = average * 1.15;
                var minus15Percent = average * 0.85;

                var averageLine = {
                    type: 'line',
                    x0: 0,
                    x1: xValues.length + 1,
                    y0: average,
                    y1: average,
                    line: {
                        color: 'black',
                        width: 2,
                        dash: 'dash'
                    }
                };

                var plus15Line = {
                    type: 'line',
                    x0: 0,
                    x1: xValues.length + 1,
                    y0: plus15Percent,
                    y1: plus15Percent,
                    line: {
                        color: 'red',
                        width: 2,
                        dash: 'dash'
                    }
                };

                var minus15Line = {
                    type: 'line',
                    x0: 0,
                    x1: xValues.length + 1,
                    y0: minus15Percent,
                    y1: minus15Percent,
                    line: {
                        color: 'green',
                        width: 2,
                        dash: 'dash'
                    }
                };

                //end calculate statistics

                var data4 = [ trace ];

                var plotContainer = document.getElementById('bottom-datavis');
                var containerWidth = plotContainer.clientWidth;
                var containerHeight = plotContainer.clientHeight * 0.75;

                var layout4 = {
                    title: 'Title 4',
                    font: { size: 16, color: document.documentElement.getAttribute('data-theme') === 'dark' ? 'white' : 'black' },
                    paper_bgcolor: document.documentElement.getAttribute('data-theme') === 'dark' ? '#2c2c2c' : 'white',
                    plot_bgcolor: document.documentElement.getAttribute('data-theme') === 'dark' ? '#2c2c2c' : 'white',
                    width: containerWidth,
                    height: containerHeight,
                    shapes: [averageLine, plus15Line, minus15Line]
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