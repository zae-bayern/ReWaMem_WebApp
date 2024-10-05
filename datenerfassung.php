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

$sitesJSON = json_encode($sites);
$userJSON = json_encode($user);
?>


<script>
	//Make data available to JS/HTML
	var userData = <?php echo $userJSON; ?>;
	var sitesData = <?php echo $sitesJSON; ?>;
    var argSiteId = <?php if ($site_id != null) {echo $site_id;} else {echo '"new"';} ?>;
</script>

<div id="siteSelector">
	<select id="siteSelect" name="site_id">
		<option value="new">New Site</option>
		<!-- Options will be populated by JavaScript -->
	</select>
</div>

<script>
// Function to populate the dropdown
function populateDropdown() {
    var select = document.getElementById('siteSelect');

    // Clear existing options except the "New Site" option
    select.innerHTML = '<option value="new">New Site</option>';

    // Add options from sitesData
    sitesData.forEach(function(site) {
      var option = document.createElement('option');
      option.value = site.id;
      option.text = site.site_name;
      select.appendChild(option);
    });

    select.value = argSiteId;
  }
  window.onload = populateDropdown;
</script>

<form id="entryForm" method="post" action="backend/create_site.php">
    <div id="bodyleft">
        <p class="side">Bitte füllen Sie für jeden Betrieb/Betriebsteil des Unternehmens ein Formular aus.<br><br>Die Formulare werden anonym ausgewertet.</p>
    </div>

    <div id="bodymain">
        <input type="hidden" name="id" id="site_id" value="">
        <div class="defaultbutton"><input type="submit" name="save" value="speichern"></div>
        <button name="delete" value="löschen" id="deleteSite">löschen</button>

        <div id="bodymainhead">
            <div class="input">
                <label class="left">Firma</label>
                <input type="text" class="text" name="company" id="company" value="">
                <input type="submit" class="button" name="new" value="Daten für einen weiteren Betrieb erfassen">
            </div>

            <div class="input">
                <label class="left">Betrieb</label>
                <input type="text" class="text" name="name" id="name" value="">
                <input type="submit" class="button" name="select" value="Vorhandene Betriebsdaten bearbeiten">
            </div>
        </div>



        <div class="input">
            <label class="opt"><b>Art des Betriebes</b></label>
            <div class="radioopts">
                <input type="radio" class="radio" name="type" value="1" id="type-1"><label for="type-1"></label>
                <label for="type-1">Wäscherei</label>
                <input type="radio" class="radio" name="type" value="2" id="type-2"><label for="type-2"></label>
                <label for="type-2">Reinigung</label>
                <input type="radio" class="radio" name="type" value="3" id="type-3"><label for="type-3"></label>
                <label for="type-3">Mischbetrieb</label>
            </div>
        </div>

        <input type="hidden" name="contact" id="contact" value="">
        <input type="hidden" name="phone" id="phone" value="">
        <input type="hidden" name="email" id="email" value="">

        <div class="input" id="mydataorg">
            <div class="opts" style="align: center;"><b>Bitte markieren Sie die Verbünde, in denen Ihr Unternehmen Mitglied ist:</b></div>
            <table>
            <tr>
                <td>
                <input type="checkbox" class="check" name="org[]" value="0" id="org-0">
                <label for="org-0">ohne</label>
                </td>
                <td>
                <input type="checkbox" class="check" name="org[]" value="servitex" id="org-servitex">
                <label for="org-servitex">Servitex</label>
                </td>
                <td>
                <input type="checkbox" class="check" name="org[]" value="sitex" id="org-sitex">
                <label for="org-sitex">Sitex</label>
                </td>
            </tr>
            <tr>
                <td>
                <input type="checkbox" class="check" name="org[]" value="dressline" id="org-dressline">
                <label for="org-dressline">Dressline</label>
                </td>
                <td>
                <input type="checkbox" class="check" name="org[]" value="nwdzentratex" id="org-nwdzentratex">
                <label for="org-nwdzentratex">NWD Zentratex</label>
                </td>
                <td>
                <input type="checkbox" class="check" name="org[]" value="lavantex" id="org-lavantex">
                <label for="org-lavantex">Lavantex</label>
                </td>
            </tr>
            <tr>
                <td>
                <input type="checkbox" class="check" name="org[]" value="tsa" id="org-tsa">
                <label for="org-tsa">TSA</label>
                </td>
                <td>
                <input type="checkbox" class="check" name="org[]" value="leosystem" id="org-leosystem">
                <label for="org-leosystem">Leosystem</label>
                </td>
                <td>
                <input type="checkbox" class="check" name="org[]" value="dbl" id="org-dbl">
                <label for="org-dbl">DBL</label>
                </td>
            </tr>
            <tr>
                <td>
                <input type="checkbox" class="check" name="org[]" value="diemietwaesche.de" id="org-diemietwaesche.de">
                <label for="org-diemietwaesche.de">diemietwaesche.de</label>
                </td>
                <td></td> <!-- Empty cell for symmetry -->
            </tr>
            </table>
        </div>
        


        <div class="input">
            <div class="opts" id="worklabel" style="align: center;">
                <b>Bitte markieren Sie die Arbeitsweisen, die für Sie typisch sind:</b>
            </div>
        </div>

        <div id="for-type-1" class="opts" style="align: center; margin-bottom: 80px;">
    <div class="input">
        <table>
            <tr>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work1-wtabwasserfrisch" value="wtabwasserfrisch">
                    <label for="work1-wtabwasserfrisch">Wärmewandler Abwasser zu Frischwasser</label>
                </td>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work1-wrabluftzufrisch" value="wrabluftzufrisch">
                    <label for="work1-wrabluftzufrisch">Wärmerückgewinnung Abluft zu Frischluft</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work1-wrabluftzuwasser" value="wrabluftzuwasser">
                    <label for="work1-wrabluftzuwasser">Wärmerückgewinnung Abluft zu Wasser</label>
                </td>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work1-wasserrueck" value="wasserrueck">
                    <label for="work1-wasserrueck">Wasserrückgewinnung</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work1-wassermehrfach" value="wassermehrfach">
                    <label for="work1-wassermehrfach">Wassermehrfachnutzung</label>
                </td>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work1-abwassersiebfilter" value="abwassersiebfilter">
                    <label for="work1-abwassersiebfilter">Abwasserbehandlung: Siebfilter</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work1-abwasserfaellung" value="abwasserfaellung">
                    <label for="work1-abwasserfaellung">Abwasserbehandlung: Fällung/Flockung</label>
                </td>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work1-abwassermikrofiltration" value="abwassermikrofiltration">
                    <label for="work1-abwassermikrofiltration">Abwasserbehandlung: Mikro-/Ultrafiltration</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work1-abwasserneutralis" value="abwasserneutralis">
                    <label for="work1-abwasserneutralis">Abwasserbehandlung: Neutralisation</label>
                </td>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work1-abwasserbiologie" value="abwasserbiologie">
                    <label for="work1-abwasserbiologie">Abwasserbehandlung: Biologie</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work1-dampfkessel" value="dampfkessel">
                    <label for="work1-dampfkessel">Dampfkessel: Abluft-Wärmewandler (ECO)</label>
                </td>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work1-dampfsystem" value="dampfsystem">
                    <label for="work1-dampfsystem">Dampf-System: Brüdendampf-Nutzung</label>
                </td>
            </tr>
        </table>
        <br>
        <label class="left">Sonstige Abwasserbehandlung:</label>
        <input type="text" class="text" name="abwasserandere" id="abwasserandere" value="">
    </div>
</div>

<div id="for-type-2" class="opts" style="align: center;">
    <div class="input">
        <table>
            <tr>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work2-kontakt" value="kontakt">
                    <label for="work2-kontakt">Kontaktwasseraufbereitung</label>
                </td>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work2-wasserrueck" value="wasserrueck">
                    <label for="work2-wasserrueck">Wasserrückgewinnung</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work2-kuehl" value="kuehl">
                    <label for="work2-kuehl">Kühlwasserrückgewinnung</label>
                </td>
                <td></td> <!-- Empty cell for alignment -->
            </tr>
        </table>
    </div>
</div>

<div id="for-type-3" class="opts" style="align: center;">
    <div class="input">
        <table>
            <tr>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work3-kontakt" value="kontakt">
                    <label for="work3-kontakt">Kontaktwasseraufbereitung</label>
                </td>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work3-wtabwasserfrisch" value="wtabwasserfrisch">
                    <label for="work3-wtabwasserfrisch">Wärmewandler Abwasser zu Frischwasser</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work3-wrabluftzufwasser" value="wrabluftzufwasser">
                    <label for="work3-wrabluftzufwasser">Wärmerückgewinnung Abluft zu Frischwasser</label>
                </td>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work3-wrabluftzufluft" value="wrabluftzufluft">
                    <label for="work3-wrabluftzufluft">Wärmerückgewinnung Abluft zu Frischluft</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work3-wasserrueck" value="wasserrueck">
                    <label for="work3-wasserrueck">Wasserrückgewinnung</label>
                </td>
                <td>
                    <input type="checkbox" class="check" name="work[]" id="work3-kuehl" value="kuehl">
                    <label for="work3-kuehl">Kühlwasserrückgewinnung</label>
                </td>
            </tr>
        </table>
    </div>
</div>

        <h2>Eingabe der Zeiträume und Verbräuche:</h2>

<div id="timespan-container" class="timespan-container">
    <div class="timespan-group" id="timespan-group-1">

        <div class="daterange-container">
            <label for="start-date">Startdatum:</label>
            <input type="text" id="start-date" name="timespans[0][start]" id="startdatum-1" placeholder="Startdatum wählen">

            <label for="end-date">Enddatum:</label>
            <input type="text" id="end-date" name="timespans[0][end]" id="enddatum-1" placeholder="Enddatum wählen">
        </div>

        <script src="3rdparty/jquery.min.js"></script>
        <script src="3rdparty/jquery-ui.js"></script>
        <script src="3rdparty/datepicker-de.js"></script>

        <script>
            $(function () {
                var startDateInput = $('#start-date');
                var endDateInput = $('#end-date');

                // Datepicker für Startdatum
                startDateInput.datepicker({
                    dateFormat: 'dd.mm.yy',
                    onSelect: function (selectedDate) {
                        var minDate = startDateInput.datepicker('getDate');
                        endDateInput.datepicker('option', 'minDate', minDate);
                    }
                }).datepicker("option", $.datepicker.regional["de"]);

                // Datepicker für Enddatum
                endDateInput.datepicker({
                    dateFormat: 'dd.mm.yy',
                    onSelect: function (selectedDate) {
                        var maxDate = endDateInput.datepicker('getDate');
                        startDateInput.datepicker('option', 'maxDate', maxDate);
                    }
                }).datepicker("option", $.datepicker.regional["de"]);

                startDateInput.datepicker("hide");
                endDateInput.datepicker("hide");

                // Force-hide the datepicker if visible on page load
                $(".ui-datepicker").hide();

                // Ensure no input is focused on page load
                $(document).ready(function() {
                    $('input').blur(); // Remove focus from any input field
                });
            });
        </script>

        <!-- Input fields for consumption data -->
        <div class="input">
            <label class="left" title="Trockenwäsche [t]">Trockenwäsche [t]: </label>
            <input type="text" class="text" name="timespans[0][trockenwaesche]" id="trockenwaesche-1" value="">
            <div class="inner note"> *inkl. Nachwäsche</div>
        </div>
        <p><b>Diese Tonnage verteilt sich prozentual auf:</b></p>
        <div class="input">
            <label class="left" title="Berufskleidung">Berufskleidung:</label>
            <input type="text" class="text" name="timespans[0][berufskleidung]" id="berufskleidung-1" value="">
        </div>
        <div style="height:20px;"></div>
        <div class="input">
            <label class="left" title="Krankenhaus/Altenheim flach">Krankenhaus/Altenheim flach:</label>
            <input type="text" class="text" name="timespans[0][krankenhaus]" id="krankenhaus-1" value="">
        </div>
        <div style="height:20px;"></div>
        <div class="input">
            <label class="left" title="Hotelwäsche">Hotelwäsche:</label>
            <input type="text" class="text" name="timespans[0][hotel]" id="hotel-1" value="">
        </div>
        <div style="height:20px;"></div>
        <div class="input">
            <label class="left" title="Bewohnerwäsche">Bewohnerwäsche:</label>
            <input type="text" class="text" name="timespans[0][bewohner]" id="bewohner-1" value="">
        </div>
        <div style="height:20px;"></div>
        <div class="input">
            <label class="left" title="Handtuchrollen">Handtuchrollen:</label>
            <input type="text" class="text" name="timespans[0][handtuch]" id="handtuch-1" value="">
        </div>
        <div style="height:20px;"></div>
        <div class="input">
            <label class="left" title="Fußmatten">Fußmatten:</label>
            <input type="text" class="text" name="timespans[0][fussmatten]" id="fussmatten-1" value="">
        </div>
        <div style="height:20px;"></div>
        <div class="input">
            <label class="left" title="Feuchtwischbezüge">Feuchtwischbezüge:</label>
            <input type="text" class="text" name="timespans[0][feuchtwisch]" id="feuchtwisch-1" value="">
        </div>
        <div style="height:20px;"></div>
        <div class="input">
            <label class="left" title="Reinigungsteile">Reinigungsteile:</label>
            <input type="text" class="text" name="timespans[0][reinigungsteile]" id="reinigungsteile-1" value="">
        </div>
        <div style="height:20px;"></div>
        <div class="input">
            <label class="left">Sonstiges:</label>
            <input type="text" class="text" name="timespans[0][sonstiges]" id="sonstiges-1" value="">
        </div>
        <div style="height:50px;"></div>
        <div>
            <p><b>Im gewählten Zeitraum wurden verbraucht:</b></p>
        </div>
        <div class="input">
            <label class="left" title="Wasser [m³]">Frischwasser [m³]:</label>
            <input type="text" class="text" name="timespans[0][wasser]" id="wasser-1" value="">
            <span class="info-button">
                <div class="tooltip">Bezogenes Frischwasser für den gesamten Betrieb, inklusive Kessel, Sozialbereich und anderer nicht-prozessrelevanter Bereiche. </div>
            </span>
            <div class="inner note">*inkl. Kessel und Sozialbereich</div>
        </div>
        <div class="input">
            <label class="left" title="Strom [kWh]">Strom [kWh]:</label>
            <input type="text" class="text" name="timespans[0][strom]" id="strom-1" value="">
            <span class="info-button">
                <div class="tooltip">Bezogene elektrische Energie für den gesamten Betrieb, einschließlich des durch Selbsterzeugung beigesteuerten Anteils. </div>
            </span>
            <div class="inner note">*inkl. Selbsterzeugung</div>
        </div>
        <div class="input">
            <label class="left" title="Öl [l]">Heizöl [l]:</label>
            <input type="text" class="text" name="timespans[0][oel]" id="oel-1" value="">
            <span class="info-button">
                <div class="tooltip">Verbrauchte Menge Heizöl in Litern. Um Ihren Energieverbrauch in kWh zu berechnen, multiplizieren Sie die eingegebene Menge in Litern mit dem Brennwert (10 kWh/L).</div>
            </span>
        </div>
        <div class="input">
            <label class="left" title="Gas [kWh]">Erdgas [kWh]:</label>
            <input type="text" class="text" name="timespans[0][gas]" id="gas-1" value="">
            <span class="info-button">
                <div class="tooltip">Bitte geben Sie den Brennwert Ihres Erdgasverbrauchs in Kilowattstunden (kWh) ein. Falls Sie Ihren Erdgasverbrauch in Kubikmetern (m³) haben, können Sie diesen mit dem durchschnittlichen Brennwert (z.B. 10,5 kWh/m³) multiplizieren. </div>
            </span>
        </div>
        <div class="input">
            <label class="left" title="Holzpellets [kWh]">Holzpellets [kWh]:</label>
            <input type="text" class="text" name="timespans[0][holz]" id="holz-1" value="">
            <span class="info-button">
                <div class="tooltip">Bitte geben Sie den Brennwert Ihres Verbrauchs an Holzpellets in Kilowattstunden (kWh) ein. Falls Sie Ihren Holzpelletsverbrauch in Kilogramm (kg) haben, können Sie diesen mit dem durchschnittlichen Brennwert (z.B. 4,9 kWh/kg) multiplizieren. </div>
            </span>
        </div>
        <div class="input">
            <label class="left" title="sonstige Energieträger [kWh]">sonstige [kWh]:</label>
            <input type="text" class="text" name="timespans[0][sonstigeenergie]" id="sonstigeenergie-1" value="">
            <span class="info-button">
                <div class="tooltip">Bitte geben Sie Ihren Energieverbrauch durch sonstige Energieträger in Kilowattstunden (kWh) an. </div>
            </span>
        </div>
        <div class="input">
            <label class="left" title="Waschmittel [kg]">Waschmittel [kg]:</label>
            <input type="text" class="text" name="timespans[0][waschmittel]" id="waschmittel-1" value="">
            <span class="info-button">
                <div class="tooltip">Bitte geben Sie Ihren Verbrauch an Waschmittel(n) in Kilogramm (kg) an. </div>
            </span>
            <div class="inner note">*inkl. Waschhilfsmittel</div>
        </div>
    </div>
</div>

<button type="button" onclick="addTimespanField()">weiteren Verbrauchszeitrum zufügen</button> 

<script src="dateselect.js"></script>

<!-- -->

<!-- -->

	<div class="buttons">
        <div class="right">
            <input type="submit" name="save" value="speichern">
        </div>
        <div class="clearer"></div>
    </div>

</div>
</form>

<script src="datenerfassung.js"></script>

<?php require_once ('footer.php'); ?>