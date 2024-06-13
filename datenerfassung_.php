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
</script>

<div id="siteSelector">
	<label for="siteSelect">Select a site:</label>
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
        <button type="button" id="deleteSite">Löschen</button>

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
            <label class="opts">Art des Betriebes</label>
            <div class="radioopts">
                <input type="radio" class="radio" name="type" value="1" id="type-1" checked><label for="type-1"></label>
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

        <div class="input">
            <div class="opts"><b>Bitte markieren Sie die Verbünde, in denen Ihr Unternehmen Mitglied ist:</b><br>&nbsp;</div>
        </div>

        <div class="input" id="mydataorg">
            <div class="opts">
                <div class="opt">
                    <input type="checkbox" class="check" name="org[]" value="0" id="org-0"><label for="org-0"></label>
                    <label for="org-0">ohne</label>
                </div>
                <div class="opt">
                    <input type="checkbox" class="check" name="org[]" value="servitex" id="org-servitex"><label for="org-servitex"></label>
                    <label for="org-servitex">Servitex</label>
                </div>
                <div class="opt">
                    <input type="checkbox" class="check" name="org[]" value="sitex" id="org-sitex"><label for="org-sitex"></label>
                    <label for="org-sitex">Sitex</label>
                </div>
                <div class="opt">
                    <input type="checkbox" class="check" name="org[]" value="dressline" id="org-dressline"><label for="org-dressline"></label>
                    <label for="org-dressline">Dressline</label>
                </div>
                <div class="opt">
                    <input type="checkbox" class="check" name="org[]" value="nwdzentratex" id="org-nwdzentratex"><label for="org-nwdzentratex"></label>
                    <label for="org-nwdzentratex">NWD Zentratex</label>
                </div>
                <div class="opt">
                    <input type="checkbox" class="check" name="org[]" value="lavantex" id="org-lavantex"><label for="org-lavantex"></label>
                    <label for="org-lavantex">Lavantex</label>
                </div>
                <div class="opt">
                    <input type="checkbox" class="check" name="org[]" value="tsa" id="org-tsa"><label for="org-tsa"></label>
                    <label for="org-tsa">TSA</label>
                </div>
                <div class="opt">
                    <input type="checkbox" class="check" name="org[]" value="leosystem" id="org-leosystem"><label for="org-leosystem"></label>
                    <label for="org-leosystem">Leosystem</label>
                </div>
                <div class="opt">
                    <input type="checkbox" class="check" name="org[]" value="dbl" id="org-dbl"><label for="org-dbl"></label>
                    <label for="org-dbl">DBL</label>
                </div>
                <div class="opt">
                    <input type="checkbox" class="check" name="org[]" value="diemietwaesche.de" id="org-diemietwaesche.de"><label for="org-diemietwaesche.de"></label>
                    <label for="org-diemietwaesche.de">diemietwaesche.de</label>
                </div>
            </div>
            <div class="clearer"></div>
        </div>

        <div class="input">
            <div class="opts" id="worklabel">
                <b>Bitte markieren Sie die Arbeitsweisen, die für Sie typisch sind:</b>
            </div>
        </div>

        <div id="for-type-1">
            <div class="input">
                <div class="opts">
                    <input type="checkbox" class="check" name="work[]" id="work1-wtabwasserfrisch" value="wtabwasserfrisch" checked><label for="work1-wtabwasserfrisch"></label>
                    <label for="work1-wtabwasserfrisch">Wärmetauscher Abwasser zu Frischwasser</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work1-wrabluftzufrisch" value="wrabluftzufrisch"><label for="work1-wrabluftzufrisch"></label>
                    <label for="work1-wrabluftzufrisch">Wärmerückgewinnung Abluft zu Frischluft</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work1-wrabluftzuwasser" value="wrabluftzuwasser"><label for="work1-wrabluftzuwasser"></label>
                    <label for="work1-wrabluftzuwasser">Wärmerückgewinnung Abluft zu Wasser</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work1-wasserrueck" value="wasserrueck" checked><label for="work1-wasserrueck"></label>
                    <label for="work1-wasserrueck">Wasserrückgewinnung</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work1-wassermehrfach" value="wassermehrfach" checked><label for="work1-wassermehrfach"></label>
                    <label for="work1-wassermehrfach">Wassermehrfachnutzung</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work1-abwassersiebfilter" value="abwassersiebfilter"><label for="work1-abwassersiebfilter"></label>
                    <label for="work1-abwassersiebfilter">Abwasserbehandlung: Siebfilter</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work1-abwasserfaellung" value="abwasserfaellung"><label for="work1-abwasserfaellung"></label>
                    <label for="work1-abwasserfaellung">Abwasserbehandlung: Fällung/Flockung</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work1-abwassermikrofiltration" value="abwassermikrofiltration" checked><label for="work1-abwassermikrofiltration"></label>
                    <label for="work1-abwassermikrofiltration">Abwasserbehandlung: Mikro-/Ultrafiltration</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work1-abwasserneutralis" value="abwasserneutralis"><label for="work1-abwasserneutralis"></label>
                    <label for="work1-abwasserneutralis">Abwasserbehandlung: Neutralis</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work1-abwasserbiologie" value="abwasserbiologie"><label for="work1-abwasserbiologie"></label>
                    <label for="work1-abwasserbiologie">Abwasserbehandlung: Biologie</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work1-dampfkessel" value="dampfkessel"><label for="work1-dampfkessel"></label>
                    <label for="work1-dampfkessel">Dampfkessel: Abluft-Wärmetausch (ECO)</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work1-dampfsystem" value="dampfsystem"><label for="work1-dampfsystem"></label>
                    <label for="work1-dampfsystem">Dampf-System: Brüdendampf-Nutzung</label><br>
                </div><br>
                <label class="left">sonstige Abwasserbehandlung</label>
                <input type="text" class="text" name="abwasserandere" id="abwasserandere" value=""><br>
            </div>
        </div>

        <div id="for-type-2">
            <div class="input">
                <div class="opts">
                    <input type="checkbox" class="check" name="work[]" id="work2-kontakt" value="kontakt"><label for="work2-kontakt"></label>
                    <label for="work2-kontakt">Kontaktwasseraufbereitung</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work2-wasserrueck" value="wasserrueck" checked><label for="work2-wasserrueck"></label>
                    <label for="work2-wasserrueck">Wasserrückgewinnung</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work2-kuehl" value="kuehl"><label for="work2-kuehl"></label>
                    <label for="work2-kuehl">Kühlwasserrückgewinnung</label><br>
                </div>
            </div>
        </div>

        <div id="for-type-3">
            <div class="input">
                <div class="opts">
                    <input type="checkbox" class="check" name="work[]" id="work3-kontakt" value="kontakt"><label for="work3-kontakt"></label>
                    <label for="work3-kontakt">Kontaktwasseraufbereitung</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work3-wtabwasserfrisch" value="wtabwasserfrisch" checked><label for="work3-wtabwasserfrisch"></label>
                    <label for="work3-wtabwasserfrisch">Wärmetauscher Abwasser zu Frischwasser</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work3-wrabluftzufwasser" value="wrabluftzufwasser"><label for="work3-wrabluftzufwasser"></label>
                    <label for="work3-wrabluftzufwasser">Wärmerückgewinnung Abluft zu Frischwasser</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work3-wrabluftzufluft" value="wrabluftzufluft"><label for="work3-wrabluftzufluft"></label>
                    <label for="work3-wrabluftzufluft">Wärmerückgewinnung Abluft zu Frischluft</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work3-wasserrueck" value="wasserrueck" checked><label for="work3-wasserrueck"></label>
                    <label for="work3-wasserrueck">Wasserrückgewinnung</label><br>
                    <input type="checkbox" class="check" name="work[]" id="work3-kuehl" value="kuehl"><label for="work3-kuehl"></label>
                    <label for="work3-kuehl">Kühlwasserrückgewinnung</label><br>
                </div>
            </div>
        </div>


        <h2>Eingabe der Zeiträume und Verbräuche:</h2>

<div id="timespan-container" class="timespan-container">
    <div class="timespan-group" id="timespan-group-1">
        <div class="month-checkboxes">
            <label>Zeitraum (Monate):</label><br>
            <input type="checkbox" id="jan-1" name="timespans[0][months][]" value="Januar"><label for="jan-1"> Januar</label>
            <input type="checkbox" id="feb-1" name="timespans[0][months][]" value="Februar"><label for="feb-1"> Februar</label>
            <input type="checkbox" id="mar-1" name="timespans[0][months][]" value="März"><label for="mar-1"> März</label>
            <input type="checkbox" id="apr-1" name="timespans[0][months][]" value="April"><label for="apr-1"> April</label>
            <input type="checkbox" id="may-1" name="timespans[0][months][]" value="Mai"><label for="may-1"> Mai</label>
            <input type="checkbox" id="jun-1" name="timespans[0][months][]" value="Juni"><label for="jun-1"> Juni</label>
            <input type="checkbox" id="jul-1" name="timespans[0][months][]" value="Juli"><label for="jul-1"> Juli</label>
            <input type="checkbox" id="aug-1" name="timespans[0][months][]" value="August"><label for="aug-1"> August</label>
            <input type="checkbox" id="sep-1" name="timespans[0][months][]" value="September"><label for="sep-1"> September</label>
            <input type="checkbox" id="oct-1" name="timespans[0][months][]" value="Oktober"><label for="oct-1"> Oktober</label>
            <input type="checkbox" id="nov-1" name="timespans[0][months][]" value="November"><label for="nov-1"> November</label>
            <input type="checkbox" id="dec-1" name="timespans[0][months][]" value="Dezember"><label for="dec-1"> Dezember</label>
        </div>
        <div class="year-select">
            <label for="year-1">Jahr:</label>
            <select id="year-1" name="timespans[0][year]">
                <option value="">Jahr auswählen</option>
                <script>
                    var currentYear = new Date().getFullYear();
                    for (var i = currentYear; i >= currentYear - 5; i--) {
                        document.write('<option value="' + i + '">' + i + '</option>');
                    }
                </script>
            </select>
        </div>

        <!-- Input fields for consumption data -->
        <div class="input">
            <label class="left" title="Trockenwäsche [t]">Trockenwäsche [t]:</label>
            <input type="text" class="text" name="timespans[0][trockenwaesche]" id="trockenwaesche-1" value="">
            <div class="inner note">*inkl. Nachwäsche</div>
        </div>
        <p><b>Diese Tonnage verteilt sich prozentual auf:</b></p>
        <div class="input">
            <label class="left" title="Berufskleidung">Berufskleidung:</label>
            <input type="text" class="text" name="timespans[0][berufskleidung]" id="berufskleidung-1" value="">
        </div>
        <div class="input">
            <label class="left" title="Krankenhaus/Altenheim flach">Krankenhaus/Altenheim flach:</label>
            <input type="text" class="text" name="timespans[0][krankenhaus]" id="krankenhaus-1" value="">
        </div>
        <div class="input">
            <label class="left" title="Hotelwäsche">Hotelwäsche:</label>
            <input type="text" class="text" name="timespans[0][hotel]" id="hotel-1" value="">
        </div>
        <div class="input">
            <label class="left" title="Bewohnerwäsche">Bewohnerwäsche:</label>
            <input type="text" class="text" name="timespans[0][bewohner]" id="bewohner-1" value="">
        </div>
        <div class="input">
            <label class="left" title="Handtuchrollen">Handtuchrollen:</label>
            <input type="text" class="text" name="timespans[0][handtuch]" id="handtuch-1" value="">
        </div>
        <div class="input">
            <label class="left" title="Fußmatten">Fußmatten:</label>
            <input type="text" class="text" name="timespans[0][fussmatten]" id="fussmatten-1" value="">
        </div>
        <div class="input">
            <label class="left" title="Feuchtwischbezüge">Feuchtwischbezüge:</label>
            <input type="text" class="text" name="timespans[0][feuchtwisch]" id="feuchtwisch-1" value="">
        </div>
        <div class="input">
            <label class="left" title="Reinigungsteile">Reinigungsteile:</label>
            <input type="text" class="text" name="timespans[0][reinigungsteile]" id="reinigungsteile-1" value="">
        </div>
        <div class="input">
            <label class="left">Sonstiges:</label>
            <input type="text" class="text" name="timespans[0][sonstiges]" id="sonstiges-1" value="">
        </div>
        <p><b>Im gewählten Zeitraum wurden verbraucht:</b></p>
        <div class="input">
            <label class="left" title="Wasser [m³]">Wasser [m³]:</label>
            <input type="text" class="text" name="timespans[0][wasser]" id="wasser-1" value="">
            <div class="inner note">*inkl. Kessel und Sozialbereich</div>
        </div>
        <div class="input">
            <label class="left" title="Strom [kWh]">Strom [kWh]:</label>
            <input type="text" class="text" name="timespans[0][strom]" id="strom-1" value="">
            <div class="inner note">*inkl. Selbsterzeugung</div>
        </div>
        <div class="input">
            <label class="left" title="Öl [l]">Öl [l]:</label>
            <input type="text" class="text" name="timespans[0][oel]" id="oel-1" value="">
        </div>
        <div class="input">
            <label class="left" title="Gas [kWh]">Gas [kWh]:</label>
            <input type="text" class="text" name="timespans[0][gas]" id="gas-1" value="">
        </div>
        <div class="input">
            <label class="left" title="Holzpellets [kWh]">Holzpellets [kWh]:</label>
            <input type="text" class="text" name="timespans[0][holz]" id="holz-1" value="">
        </div>
        <div class="input">
            <label class="left" title="sonstige Energieträger [kWh]">sonstige Energieträger [kWh]:</label>
            <input type="text" class="text" name="timespans[0][sonstigeenergie]" id="sonstigeenergie-1" value="">
        </div>
        <div class="input">
            <label class="left" title="Waschmittel [kg]">Waschmittel [kg]:</label>
            <input type="text" class="text" name="timespans[0][waschmittel]" id="waschmittel-1" value="">
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
        <div class="left">
            <input type="submit" name="back" value="abbrechen">
        </div>
        <div class="clearer"></div>
    </div>

		</div>

</form>

<script>
// Function to update form fields based on selection
    function updateFormFields() {
        var select = document.getElementById('siteSelect');
        var selectedSiteId = select.value;

        if (selectedSiteId === "new") {
            // Clear all form fields for new site
            document.getElementById('company').value = "";
            document.getElementById('name').value = "";
            document.getElementById('contact').value = "";
            document.getElementById('phone').value = "";
            document.getElementById('email').value = "";
            document.getElementById('trockenwaesche').value = "";
            document.getElementById('berufskleidung').value = "";
            document.getElementById('krankenhaus').value = "";
            document.getElementById('hotel').value = "";
            document.getElementById('bewohner').value = "";
            document.getElementById('handtuch').value = "";
            document.getElementById('fussmatten').value = "";
            document.getElementById('feuchtwisch').value = "";
            document.getElementById('reinigungsteile').value = "";
            document.getElementById('sonstiges').value = "";
            document.getElementById('wasser').value = "";
            document.getElementById('strom').value = "";
            document.getElementById('oel').value = "";
            document.getElementById('gas').value = "";
            document.getElementById('holz').value = "";
            document.getElementById('sonstigeenergie').value = "";
            document.getElementById('waschmittel').value = "";
            document.getElementById('abwasserandere').value = "";
            // Add other fields as needed
        } else {
            // Find the selected site data
            var selectedSite = sitesData.find(site => site.id == selectedSiteId);
            if (selectedSite) {
                // Populate form fields with selected site data
                document.getElementById('company').value = selectedSite.site_data.company;
                document.getElementById('name').value = selectedSite.site_data.name;
                document.getElementById('contact').value = selectedSite.site_data.contact;
                document.getElementById('phone').value = selectedSite.site_data.phone;
                document.getElementById('email').value = selectedSite.site_data.email;
                document.getElementById('trockenwaesche').value = selectedSite.site_data.trockenwaesche;
                document.getElementById('berufskleidung').value = selectedSite.site_data.berufskleidung;
                document.getElementById('krankenhaus').value = selectedSite.site_data.krankenhaus;
                document.getElementById('hotel').value = selectedSite.site_data.hotel;
                document.getElementById('bewohner').value = selectedSite.site_data.bewohner;
                document.getElementById('handtuch').value = selectedSite.site_data.handtuch;
                document.getElementById('fussmatten').value = selectedSite.site_data.fussmatten;
                document.getElementById('feuchtwisch').value = selectedSite.site_data.feuchtwisch;
                document.getElementById('reinigungsteile').value = selectedSite.site_data.reinigungsteile;
                document.getElementById('sonstiges').value = selectedSite.site_data.sonstiges;
                document.getElementById('wasser').value = selectedSite.site_data.wasser;
                document.getElementById('strom').value = selectedSite.site_data.strom;
                document.getElementById('oel').value = selectedSite.site_data.oel;
                document.getElementById('gas').value = selectedSite.site_data.gas;
                document.getElementById('holz').value = selectedSite.site_data.holz;
                document.getElementById('sonstigeenergie').value = selectedSite.site_data.sonstigeenergie;
                document.getElementById('waschmittel').value = selectedSite.site_data.waschmittel;
                document.getElementById('abwasserandere').value = selectedSite.site_data.abwasserandere;
                // Add other fields as needed
            }
        }
    }

    window.onload = function() {
        populateDropdown();
        document.getElementById('siteSelect').addEventListener('change', updateFormFields);

        document.getElementById('deleteSite').addEventListener('click', function() {
        var select = document.getElementById('siteSelect');
        var selectedSiteId = select.value;

        if (selectedSiteId === "new") {
            alert("Bitte wählen Sie eine vorhandene Seite aus, um sie zu löschen.");
            return;
        }

        if (confirm("Sind Sie sicher, dass Sie diese Seite löschen möchten?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "backend/delete_site.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    // Remove the deleted entry from the dropdown and select the previous one
                    var optionToRemove = select.querySelector('option[value="' + selectedSiteId + '"]');
                    if (optionToRemove) {
                        var previousOption = optionToRemove.previousElementSibling;
                        optionToRemove.remove();
                        if (previousOption) {
                            previousOption.selected = true;
                        } else {
                            select.value = "new";
                        }
                        updateFormFields();
                    }
                }
            };
            xhr.send("id=" + selectedSiteId);
        }
        });

        // If a site ID is provided in the URL, update the form fields
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('site_id')) {
            var siteIdFromUrl = urlParams.get('site_id');
            updateFormFields(siteIdFromUrl);
        }
    }
</script>

<script src="datenerfassung.js"></script>

<?php require_once ('footer.php'); ?>