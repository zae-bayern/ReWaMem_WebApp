<?php require_once ('header.php'); ?>

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

//Fetch site(s) data (for the current user only) from the database
$sql = "SELECT * FROM sites WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
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

//Make data available in JS/HTML (site_data is JSON anyhow)
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


<form id="entryForm" method="post" action="backend/create_site.php">

	<div id="bodyleft">
		<p class="side">Bitte füllen Sie für jeden Betrieb/Betriebsteil des Unternehmens
			ein Formular aus.<br><br>Die Fomulare werden anonym ausgewertet.</p>
	</div>

	<div id="bodymain">
		<input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
		<div class="defaultbutton"><input type="submit" name="save" value="speichern"></div>

		<div id="bodymainhead">
			<div class="input">
				<label class="left">Firma </label>
				<input type="text" class="text" name="company" value="<?php echo htmlspecialchars($user['company']); ?>">
				<input type="submit" class="button" name="new" value="Daten für einen weiteren Betrieb erfassen">
			</div>

			<div class="input">
				<label class="left">Betrieb</label>
				<input type="text" class="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
				<input type="submit" class="button" name="select" value="Vorhandene Betriebsdaten bearbeiten">
			</div>
		</div>

		<div class="input">
			<label class="opts">Art des Betriebes</label>
			<div class="radioopts">
				<input type="radio" class="radio" name="type" value="1" id="type-1" <?php echo ($user['type'] == 1) ? 'checked' : ''; ?>><label for="type-1"></label>
				<label for="type-1">Wäscherei</label>
				<input type="radio" class="radio" name="type" value="2" id="type-2" <?php echo ($user['type'] == 2) ? 'checked' : ''; ?>><label for="type-2"></label>
				<label for="type-2">Reinigung</label>
				<input type="radio" class="radio" name="type" value="3" id="type-3" <?php echo ($user['type'] == 3) ? 'checked' : ''; ?>><label for="type-3"></label>
				<label for="type-3">Mischbetrieb</label>
			</div>
		</div>

		<input type="hidden" name="contact" value="<?php echo htmlspecialchars($user['contact']); ?>">
		<input type="hidden" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
		<input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">

		<div class="input">
			<div class="opts"><b>Bitte markieren Sie die Verbünde, in denen
					Ihr Unternehmen Mitglied ist:</b><br>&nbsp;</div>
		</div>

		<div class="input" id="mydataorg">
			<div class="opts">
				<div class="opt">
					<input type="checkbox" class="check" name="org[]" value="0" id="org-0" <?php echo in_array("0", explode(",", $user['org'])) ? 'checked' : ''; ?>><label for="org-0"></label>
					<label for="org-0">ohne</label>
				</div>
				<div class="opt">
					<input type="checkbox" class="check" name="org[]" value="servitex" id="org-servitex" <?php echo in_array("servitex", explode(",", $user['org'])) ? 'checked' : ''; ?>><label for="org-servitex"></label>
					<label for="org-servitex">Servitex</label>
				</div>
				<div class="opt">
					<input type="checkbox" class="check" name="org[]" value="sitex" id="org-sitex" <?php echo in_array("sitex", explode(",", $user['org'])) ? 'checked' : ''; ?>><label for="org-sitex"></label>
					<label for="org-sitex">Sitex</label>
				</div>
				<div class="opt">
					<input type="checkbox" class="check" name="org[]" value="dressline" id="org-dressline" <?php echo in_array("dressline", explode(",", $user['org'])) ? 'checked' : ''; ?>><label for="org-dressline"></label>
					<label for="org-dressline">Dressline</label>
				</div>
				<div class="opt">
					<input type="checkbox" class="check" name="org[]" value="nwdzentratex" id="org-nwdzentratex" <?php echo in_array("nwdzentratex", explode(",", $user['org'])) ? 'checked' : ''; ?>><label for="org-nwdzentratex"></label>
					<label for="org-nwdzentratex">NWD Zentratex</label>
				</div>
				<div class="opt">
					<input type="checkbox" class="check" name="org[]" value="lavantex" id="org-lavantex" <?php echo in_array("lavantex", explode(",", $user['org'])) ? 'checked' : ''; ?>><label for="org-lavantex"></label>
					<label for="org-lavantex">Lavantex</label>
				</div>
				<div class="opt">
					<input type="checkbox" class="check" name="org[]" value="tsa" id="org-tsa" <?php echo in_array("tsa", explode(",", $user['org'])) ? 'checked' : ''; ?>><label for="org-tsa"></label>
					<label for="org-tsa">TSA</label>
				</div>
				<div class="opt">
					<input type="checkbox" class="check" name="org[]" value="leosystem" id="org-leosystem" <?php echo in_array("leosystem", explode(",", $user['org'])) ? 'checked' : ''; ?>><label for="org-leosystem"></label>
					<label for="org-leosystem">Leosystem</label>
				</div>
				<div class="opt">
					<input type="checkbox" class="check" name="org[]" value="dbl" id="org-dbl" <?php echo in_array("dbl", explode(",", $user['org'])) ? 'checked' : ''; ?>><label for="org-dbl"></label>
					<label for="org-dbl">DBL</label>
				</div>
				<div class="opt">
					<input type="checkbox" class="check" name="org[]" value="diemietwaesche.de" id="org-diemietwaesche.de" <?php echo in_array("diemietwaesche.de", explode(",", $user['org'])) ? 'checked' : ''; ?>><label for="org-diemietwaesche.de"></label>
					<label for="org-diemietwaesche.de">diemietwaesche.de</label>
				</div>
			</div>
			<div class="clearer"></div>
		</div>

		<div class="input">
			<div class="opts" id="worklabel">
				<b>Bitte markieren Sie die Arbeitsweisen, die für Sie
					typisch sind:</b>
			</div>
		</div>

		<div id="for-type-1">
			<div class="input">
				<div class="opts">
					<input type="checkbox" class="check" name="work[]" id="work1-wtabwasserfrisch" value="wtabwasserfrisch" <?php echo in_array("wtabwasserfrisch", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work1-wtabwasserfrisch"></label>
					<label for="work1-wtabwasserfrisch">Wärmetauscher Abwasser zu Frischwasser</label><br>
					<input type="checkbox" class="check" name="work[]" id="work1-wrabluftzufrisch" value="wrabluftzufrisch" <?php echo in_array("wrabluftzufrisch", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work1-wrabluftzufrisch"></label>
					<label for="work1-wrabluftzufrisch">Wärmerückgewinnung Abluft zu Frischluft</label><br>
					<input type="checkbox" class="check" name="work[]" id="work1-wrabluftzuwasser" value="wrabluftzuwasser" <?php echo in_array("wrabluftzuwasser", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work1-wrabluftzuwasser"></label>
					<label for="work1-wrabluftzuwasser">Wärmerückgewinnung Abluft zu Wasser</label><br>
					<input type="checkbox" class="check" name="work[]" id="work1-wasserrueck" value="wasserrueck" <?php echo in_array("wasserrueck", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work1-wasserrueck"></label>
					<label for="work1-wasserrueck">Wasserrückgewinnung</label><br>
					<input type="checkbox" class="check" name="work[]" id="work1-wassermehrfach" value="wassermehrfach" <?php echo in_array("wassermehrfach", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work1-wassermehrfach"></label>
					<label for="work1-wassermehrfach">Wassermehrfachnutzung</label><br>
					<input type="checkbox" class="check" name="work[]" id="work1-abwassersiebfilter" value="abwassersiebfilter" <?php echo in_array("abwassersiebfilter", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work1-abwassersiebfilter"></label>
					<label for="work1-abwassersiebfilter">Abwasserbehandlung: Siebfilter</label><br>
					<input type="checkbox" class="check" name="work[]" id="work1-abwasserfaellung" value="abwasserfaellung" <?php echo in_array("abwasserfaellung", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work1-abwasserfaellung"></label>
					<label for="work1-abwasserfaellung">Abwasserbehandlung: Fällung/Flockung</label><br>
					<input type="checkbox" class="check" name="work[]" id="work1-abwassermikrofiltration" value="abwassermikrofiltration" <?php echo in_array("abwassermikrofiltration", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work1-abwassermikrofiltration"></label>
					<label for="work1-abwassermikrofiltration">Abwasserbehandlung: Mikro-/Ultrafiltration</label><br>
					<input type="checkbox" class="check" name="work[]" id="work1-abwasserneutralis" value="abwasserneutralis" <?php echo in_array("abwasserneutralis", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work1-abwasserneutralis"></label>
					<label for="work1-abwasserneutralis">Abwasserbehandlung: Neutralis</label><br>
					<input type="checkbox" class="check" name="work[]" id="work1-abwasserbiologie" value="abwasserbiologie" <?php echo in_array("abwasserbiologie", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work1-abwasserbiologie"></label>
					<label for="work1-abwasserbiologie">Abwasserbehandlung: Biologie</label><br>
					<input type="checkbox" class="check" name="work[]" id="work1-dampfkessel" value="dampfkessel" <?php echo in_array("dampfkessel", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work1-dampfkessel"></label>
					<label for="work1-dampfkessel">Dampfkessel: Abluft-Wärmetausch (ECO)</label><br>
					<input type="checkbox" class="check" name="work[]" id="work1-dampfsystem" value="dampfsystem" <?php echo in_array("dampfsystem", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work1-dampfsystem"></label>
					<label for="work1-dampfsystem">Dampf-System: Brüdendampf-Nutzung</label><br>
				</div><br>
				<label class="left">sonstige Abwasserbehandlung</label>
				<input type="text" class="text" name="abwasserandere" value="<?php echo htmlspecialchars($user['abwasserandere']); ?>"><br>
			</div>
		</div>

		<div id="for-type-2">
			<div class="input">
				<div class="opts">
					<input type="checkbox" class="check" name="work[]" id="work2-kontakt" value="kontakt" <?php echo in_array("kontakt", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work2-kontakt"></label>
					<label for="work2-kontakt">Kontaktwasseraufbereitung</label><br>
					<input type="checkbox" class="check" name="work[]" id="work2-wasserrueck" value="wasserrueck" <?php echo in_array("wasserrueck", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work2-wasserrueck"></label>
					<label for="work2-wasserrueck">Wasserrückgewinnung</label><br>
					<input type="checkbox" class="check" name="work[]" id="work2-kuehl" value="kuehl" <?php echo in_array("kuehl", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work2-kuehl"></label>
					<label for="work2-kuehl">Kühlwasserrückgewinnung</label><br>
				</div>
			</div>
		</div>

		<div id="for-type-3">
			<div class="input">
				<div class="opts">
					<input type="checkbox" class="check" name="work[]" id="work3-kontakt" value="kontakt" <?php echo in_array("kontakt", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work3-kontakt"></label>
					<label for="work3-kontakt">Kontaktwasseraufbereitung</label><br>
					<input type="checkbox" class="check" name="work[]" id="work3-wtabwasserfrisch" value="wtabwasserfrisch" <?php echo in_array("wtabwasserfrisch", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work3-wtabwasserfrisch"></label>
					<label for="work3-wtabwasserfrisch">Wärmetauscher Abwasser zu Frischwasser</label><br>
					<input type="checkbox" class="check" name="work[]" id="work3-wrabluftzufwasser" value="wrabluftzufwasser" <?php echo in_array("wrabluftzufwasser", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work3-wrabluftzufwasser"></label>
					<label for="work3-wrabluftzufwasser">Wärmerückgewinnung Abluft zu Frischwasser</label><br>
					<input type="checkbox" class="check" name="work[]" id="work3-wrabluftzufluft" value="wrabluftzufluft" <?php echo in_array("wrabluftzufluft", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work3-wrabluftzufluft"></label>
					<label for="work3-wrabluftzufluft">Wärmerückgewinnung Abluft zu Frischluft</label><br>
					<input type="checkbox" class="check" name="work[]" id="work3-wasserrueck" value="wasserrueck" <?php echo in_array("wasserrueck", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work3-wasserrueck"></label>
					<label for="work3-wasserrueck">Wasserrückgewinnung</label><br>
					<input type="checkbox" class="check" name="work[]" id="work3-kuehl" value="kuehl" <?php echo in_array("kuehl", explode(",", $user['work'])) ? 'checked' : ''; ?>><label for="work3-kuehl"></label>
					<label for="work3-kuehl">Kühlwasserrückgewinnung</label><br>
				</div>
			</div>
		</div>

		<h2>Eingabe der Verbräuche:</h2>

		<div id="dateselect">
			<div>Wählen Sie einen Zeitraum:<br>
				Sie haben die Möglichkeit, die Daten für ein bestimmtes Jahr,
				einen bestimmten Monat oder einen bestimmten Tag auswerten zu lassen.
			</div>
			<select name="year">
				<option value="">Jahr</option>
				<?php
					$currentYear = date('Y');
					for ($i = $currentYear; $i > $currentYear - 5; $i--) {
						echo "<option value='$i' " . ($user['year'] == $i ? 'selected' : '') . ">$i</option>";
					}
				?>
			</select>
			<select name="month" class="clearable">
				<option value="">Monat</option>
				<option value="1" <?php echo ($user['month'] == 1) ? 'selected' : ''; ?>>Januar</option>
				<option value="2" <?php echo ($user['month'] == 2) ? 'selected' : ''; ?>>Februar</option>
				<option value="3" <?php echo ($user['month'] == 3) ? 'selected' : ''; ?>>März</option>
				<option value="4" <?php echo ($user['month'] == 4) ? 'selected' : ''; ?>>April</option>
				<option value="5" <?php echo ($user['month'] == 5) ? 'selected' : ''; ?>>Mai</option>
				<option value="6" <?php echo ($user['month'] == 6) ? 'selected' : ''; ?>>Juni</option>
				<option value="7" <?php echo ($user['month'] == 7) ? 'selected' : ''; ?>>Juli</option>
				<option value="8" <?php echo ($user['month'] == 8) ? 'selected' : ''; ?>>August</option>
				<option value="9" <?php echo ($user['month'] == 9) ? 'selected' : ''; ?>>September</option>
				<option value="10" <?php echo ($user['month'] == 10) ? 'selected' : ''; ?>>Oktober</option>
				<option value="11" <?php echo ($user['month'] == 11) ? 'selected' : ''; ?>>November</option>
				<option value="12" <?php echo ($user['month'] == 12) ? 'selected' : ''; ?>>Dezember</option>
			</select>
			<select name="day" class="clearable">
				<option value="">Tag</option>
				<option value="1" <?php echo ($user['day'] == 1) ? 'selected' : ''; ?>>1</option>
				<option value="2" <?php echo ($user['day'] == 2) ? 'selected' : ''; ?>>2</option>
				<option value="3" <?php echo ($user['day'] == 3) ? 'selected' : ''; ?>>3</option>
				<option value="4" <?php echo ($user['day'] == 4) ? 'selected' : ''; ?>>4</option>
				<option value="5" <?php echo ($user['day'] == 5) ? 'selected' : ''; ?>>5</option>
				<option value="6" <?php echo ($user['day'] == 6) ? 'selected' : ''; ?>>6</option>
				<option value="7" <?php echo ($user['day'] == 7) ? 'selected' : ''; ?>>7</option>
				<option value="8" <?php echo ($user['day'] == 8) ? 'selected' : ''; ?>>8</option>
				<option value="9" <?php echo ($user['day'] == 9) ? 'selected' : ''; ?>>9</option>
				<option value="10" <?php echo ($user['day'] == 10) ? 'selected' : ''; ?>>10</option>
				<option value="11" <?php echo ($user['day'] == 11) ? 'selected' : ''; ?>>11</option>
				<option value="12" <?php echo ($user['day'] == 12) ? 'selected' : ''; ?>>12</option>
				<option value="13" <?php echo ($user['day'] == 13) ? 'selected' : ''; ?>>13</option>
				<option value="14" <?php echo ($user['day'] == 14) ? 'selected' : ''; ?>>14</option>
				<option value="15" <?php echo ($user['day'] == 15) ? 'selected' : ''; ?>>15</option>
				<option value="16" <?php echo ($user['day'] == 16) ? 'selected' : ''; ?>>16</option>
				<option value="17" <?php echo ($user['day'] == 17) ? 'selected' : ''; ?>>17</option>
				<option value="18" <?php echo ($user['day'] == 18) ? 'selected' : ''; ?>>18</option>
				<option value="19" <?php echo ($user['day'] == 19) ? 'selected' : ''; ?>>19</option>
				<option value="20" <?php echo ($user['day'] == 20) ? 'selected' : ''; ?>>20</option>
				<option value="21" <?php echo ($user['day'] == 21) ? 'selected' : ''; ?>>21</option>
				<option value="22" <?php echo ($user['day'] == 22) ? 'selected' : ''; ?>>22</option>
				<option value="23" <?php echo ($user['day'] == 23) ? 'selected' : ''; ?>>23</option>
				<option value="24" <?php echo ($user['day'] == 24) ? 'selected' : ''; ?>>24</option>
				<option value="25" <?php echo ($user['day'] == 25) ? 'selected' : ''; ?>>25</option>
				<option value="26" <?php echo ($user['day'] == 26) ? 'selected' : ''; ?>>26</option>
				<option value="27" <?php echo ($user['day'] == 27) ? 'selected' : ''; ?>>27</option>
				<option value="28" <?php echo ($user['day'] == 28) ? 'selected' : ''; ?>>28</option>
				<option value="29" <?php echo ($user['day'] == 29) ? 'selected' : ''; ?>>29</option>
				<option value="30" <?php echo ($user['day'] == 30) ? 'selected' : ''; ?>>30</option>
				<option value="31" <?php echo ($user['day'] == 31) ? 'selected' : ''; ?>>31</option>
			</select>
			<div class="clearerleft"></div>
		</div>
		<script src="dateselect.js?1"></script>

		<p><b>Wir bearbeiten im gewählten Zeitraum<br>
				[bitte geben Sie dies in absoluten Zahlen an]:</b></p>
		<div class="input">
			<label class="left" title="Trockenwäsche [t]">Trockenwäsche [t]:</label>
			<input type="text" class="text" name="trockenwaesche" value="<?php echo htmlspecialchars($user['trockenwaesche']); ?>">
			<div class="inner note">*inkl. Nachwäsche</div>
		</div>
		<p><b>Diese Tonnage verteilt sich prozentual auf:</b></p>
		<div class="input">
			<label class="left" title="Berufskleidung">Berufskleidung:</label>
			<input type="text" class="text" name="berufskleidung" value="<?php echo htmlspecialchars($user['berufskleidung']); ?>">
		</div>
		<div class="input">
			<label class="left" title="Krankenhaus/Altenheim flach">Krankenhaus/Altenheim flach:</label>
			<input type="text" class="text" name="krankenhaus" value="<?php echo htmlspecialchars($user['krankenhaus']); ?>">
		</div>
		<div class="input">
			<label class="left" title="Hotelwäsche">Hotelwäsche:</label>
			<input type="text" class="text" name="hotel" value="<?php echo htmlspecialchars($user['hotel']); ?>">
		</div>
		<div class="input">
			<label class="left" title="Bewohnerwäsche">Bewohnerwäsche:</label>
			<input type="text" class="text" name="bewohner" value="<?php echo htmlspecialchars($user['bewohner']); ?>">
		</div>
		<div class="input">
			<label class="left" title="Handtuchrollen">Handtuchrollen:</label>
			<input type="text" class="text" name="handtuch" value="<?php echo htmlspecialchars($user['handtuch']); ?>">
		</div>
		<div class="input">
			<label class="left" title="Fußmatten">Fußmatten:</label>
			 <input type="text" class="text" name="fussmatten" value="<?php echo htmlspecialchars($user['fussmatten']); ?>">
		</div>
		<div class="input">
			<label class="left" title="Feuchtwischbezüge">Feuchtwischbezüge:</label>
			<input type="text" class="text" name="feuchtwisch" value="<?php echo htmlspecialchars($user['feuchtwisch']); ?>">
		</div>
		<div class="input">
			<label class="left" title="Reinigungsteile">Reinigungsteile:</label>
			<input type="text" class="text" name="reinigungsteile" value="<?php echo htmlspecialchars($user['reinigungsteile']); ?>">
		</div>
		<div class="input">
			<label class="left">Sonstiges:</label>
			<input type="text" class="text" name="sonstiges" value="<?php echo htmlspecialchars($user['sonstiges']); ?>">
		</div>
		<p><b>Im gewählten Zeitraum wurden verbraucht:</b></p>
		<div class="input">
			<label class="left" title="Wasser [m³]">Wasser [m³]:</label>
			<input type="text" class="text" name="wasser" value="<?php echo htmlspecialchars($user['wasser']); ?>">
			<div class="inner note">*inkl. Kessel und Sozialbereich</div>
		</div>
		<div class="input">
			<label class="left" title="Strom [kWh]">Strom [kWh]:</label>
			<input type="text" class="text" name="strom" value="<?php echo htmlspecialchars($user['strom']); ?>">
			<div class="inner note">*inkl. Selbsterzeugung</div>
		</div>
		<div class="input">
			<label class="left" title="Öl [l]">Öl [l]:</label>
			<input type="text" class="text" name="oel" value="<?php echo htmlspecialchars($user['oel']); ?>">
		</div>
		<div class="input">
			<label class="left" title="Gas [kWh]">Gas [kWh]:</label>
			<input type="text" class="text" name="gas" value="<?php echo htmlspecialchars($user['gas']); ?>">
		</div>
		<div class="input">
			<label class="left" title="Holzpellets [kWh]">Holzpellets [kWh]:</label>
			<input type="text" class="text" name="holz" value="<?php echo htmlspecialchars($user['holz']); ?>">
		</div>
		<div class="input">
			<label class="left" title="sonstige Energieträger [kWh]">sonstige Energieträger [kWh]:</label>
			<input type="text" class="text" name="sonstigeenergie" value="<?php echo htmlspecialchars($user['sonstigeenergie']); ?>">
		</div>
		<div class="input">
			<label class="left" title="Waschmittel [kg]">Waschmittel [kg]:</label>
			<input type="text" class="text" name="waschmittel" value="<?php echo htmlspecialchars($user['waschmittel']); ?>">
			<div class="inner note">*inkl. Waschhilfsmittel</div>
		</div>

	</div>
	
	<div class="buttons">
		<div class="right">
			<input type="submit" name="save" value="speichern">
		</div>
		<div class="left">
			<input type="submit" name="back" value="abbrechen">
		</div>
		<div class="clearer"></div>
	</div>
</form>

<script src="datenerfassung.js"></script>

<?php require_once ('footer.php'); ?>
