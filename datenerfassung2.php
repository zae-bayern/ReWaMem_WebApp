<?php require_once('header.php');?>

<?php
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page:
    header("Location: login.php");
    exit;
}
?>

<!-- as generated by the old version -->
<!-- Danach: Anzeige Dashboard-->

<form method=post action="/datenerfassung/view-default/default">
<div class=defaultbutton><input type=submit name=save value=save></div>

<div id=bodyright>
<p class=side>Wählen Sie einen Zeitraum:<br>
Sie haben die Möglichkeit, die Daten für ein bestimmtes Jahr,
einen bestimmten Monat oder einen bestimmten Tag auswerten zu lassen.
</div>

<div id=bodymain2>
<h2>Eingabe der Verbräuche:<br>CHMS Rödental / ReWaMem Pilotanlage</h2>

<div id=dateselect>
<select name=year>
<option value="">Jahr
<option value=2019>2019<option value=2020>2020<option value=2021>2021<option value=2022>2022<option value=2023>2023<option value=2024>2024</select>
<select name=month class=clearable>
<option value="">Monat
<option value=1>Januar<option value=2>Februar<option value=3>März<option value=4>April<option value=5>Mai<option value=6>Juni<option value=7>Juli<option value=8>August<option value=9>September<option value=10>Oktober<option value=11>November<option value=12>Dezember</select>
<select name=day class=clearable>
<option value="">Tag
<option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10<option value=11>11<option value=12>12<option value=13>13<option value=14>14<option value=15>15<option value=16>16<option value=17>17<option value=18>18<option value=19>19<option value=20>20<option value=21>21<option value=22>22<option value=23>23<option value=24>24<option value=25>25<option value=26>26<option value=27>27<option value=28>28<option value=29>29<option value=30>30<option value=31>31</select>
<div class=clearerleft></div>
</div>
<script src="/components/com_oekobench/views/default/tmpl/datesel.js?1"
	></script>

<p>&nbsp;</p>
<p><b>Wir bearbeiten im gewählten Zeitraum<br>
		[bitte geben Sie dies in absoluten Zahlen an]:</b></p>
<div class=input>
<label class=left title="Trockenwäsche [t]"
	>Trockenwäsche [t]:</label>
<input type=text class=text name="trockenwaesche" value="">
<div class="inner note">*inkl. Nachwäsche</div>
</div>
<p>&nbsp;</p>
<p><b>Diese Tonnage verteilt sich prozentual auf:</b></p>
<div class=input>
<label class=left title="Berufskleidung"
	>Berufskleidung:</label>
<input type=text class=text name="berufskleidung" value="">
</div>
<div class=input>
<label class=left title="Krankenhaus/Altenheim flach"
	>Krankenhaus/Altenheim flach:</label>
<input type=text class=text name="krankenhaus" value="">
</div>
<div class=input>
<label class=left title="Hotelwäsche"
	>Hotelwäsche:</label>
<input type=text class=text name="hotel" value="">
</div>
<div class=input>
<label class=left title="Bewohnerwäsche"
	>Bewohnerwäsche:</label>
<input type=text class=text name="bewohner" value="">
</div>
<div class=input>
<label class=left title="Handtuchrollen"
	>Handtuchrollen:</label>
<input type=text class=text name="handtuch" value="">
</div>
<div class=input>
<label class=left title="Fußmatten"
	>Fußmatten:</label>
<input type=text class=text name="fussmatten" value="">
</div>
<div class=input>
<label class=left title="Feuchtwischbezüge"
	>Feuchtwischbezüge:</label>
<input type=text class=text name="feuchtwisch" value="">
</div>
<div class=input>
<label class=left title="Reinigungsteile"
	>Reinigungsteile:</label>
<input type=text class=text name="reinigungsteile" value="">
</div>
<div>&nbsp;</div><div class=input>
<label class=left>Sonstiges:</label>
<input type=text class=text name="sonstiges" value="">
</div>
<p>&nbsp;</p>
<p><b>Im gewählten Zeitraum wurden verbraucht:</b></p>
<div class=input>
<label class=left title="Wasser [m³]"
	>Wasser [m³]:</label>
<input type=text class=text name="wasser" value="">
<div class="inner note">*inkl. Kessel und Sozialbereich</div>
</div>
<div class=input>
<label class=left title="Strom [kWh]"
	>Strom [kWh]:</label>
<input type=text class=text name="strom" value="">
<div class="inner note">*inkl. Selbsterzeugung</div>
</div>
<div class=input>
<label class=left title="Öl [l]"
	>Öl [l]:</label>
<input type=text class=text name="oel" value="">
</div>
<div class=input>
<label class=left title="Gas [kWh]"
	>Gas [kWh]:</label>
<input type=text class=text name="gas" value="">
</div>
<div class=input>
<label class=left title="Holzpellets [kWh]"
	>Holzpellets [kWh]:</label>
<input type=text class=text name="holz" value="">
</div>
<div class=input>
<label class=left title="sonstige Energieträger [kWh]"
	>sonstige Energieträger [kWh]:</label>
<input type=text class=text name="sonstigeenergie" value="">
</div>
<div class=input>
<label class=left title="Waschmittel [kg]"
	>Waschmittel [kg]:</label>
<input type=text class=text name="waschmittel" value="">
<div class="inner note">*inkl. Waschhilfsmittel</div>
</div>

</div><!-- #bodymain2 -->

<div class=clearer></div>

<p>&nbsp;</p>
<div class=buttons>
<div class=right>
<input type=submit name=prev value="zurück">
<input type=submit name=save value="speichern">
<input type=submit name=cont value="weiter">
</div>
<div class=left>
<input type=submit name=cancel value="abbrechen">
</div>
<div class=clearer></div>
</div><!-- .buttons -->

</form>

<?php require_once('footer.php'); ?>