<?php require_once('header.php');?>

<?php
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page:
    header("Location: login.php");
    exit;
}
?>

<form method=post action="/backend/create_site.php">

<div id=bodyleft>
<p class=side>Bitte füllen Sie für jeden Betrieb/Betriebsteil des Unternehmens
ein Formular aus.<br>Die Fomulare werden anonym ausgewertet.</p>
</div>

<div id=bodymain>
<input type=hidden name=id value="">
<div class=defaultbutton><input type=submit name=save value=save></div>

<div class=input><label class=left>Firma</label>
<input type=text class=text name=company
	value="">
<input type=submit class=button name=new
	value="Daten für einen weiteren Betrieb erfassen">
</div>

<div class=input><label class=left>Betrieb</label>
<input type=text class=text name=name
	value="">
<input type=submit class=button name=select
	value="Vorhandene Betriebsdaten bearbeiten">
</div>

<div class=input>
<label class="opts">Art des Betriebes</label>
<div class=radioopts>
<input type=radio class=radio name=type value=1 id=type-1
	 checked	><label for=type-1></label>
	<label for=type-1>Wäscherei</label>
<input type=radio class=radio name=type value=2 id=type-2
		><label for=type-2></label>
	<label for=type-2>Reinigung</label>
<input type=radio class=radio name=type value=3 id=type-3
		><label for=type-3></label>
	<label for=type-3>Mischbetrieb</label>
</div>
</div>

<input type=hidden name=contact value="">
<input type=hidden name=phone value="">
<input type=hidden name=email value="">


<p>&nbsp;</p>
<div class=input>
<label class=left>&nbsp;</label>
<div class=opts><b>Bitte markieren Sie die Verbünde, in denen
Ihr Unternehmen Mitglied ist:</b><br>&nbsp;</div></div>

<div class=input id="mydataorg">
<label class=left>&nbsp;</label>
<div class="opts">
<div class=opt>
	<input type=checkbox class=check name="org[]" value="0" id="org-0"
		 ><label for="org-0"></label>
	<label for="org-0">ohne</label>
</div>
<div class=opt>
	<input type=checkbox class=check name="org[]" value="servitex" id="org-servitex"
			><label for="org-servitex"></label>
	<label for="org-servitex">Servitex</label>
</div>
<div class=opt>
	<input type=checkbox class=check name="org[]" value="sitex" id="org-sitex"
			><label for="org-sitex"></label>
	<label for="org-sitex">Sitex</label>
</div>
<div class=opt>
	<input type=checkbox class=check name="org[]" value="dressline" id="org-dressline"
			><label for="org-dressline"></label>
	<label for="org-dressline">Dressline</label>
</div>
<div class=opt>
	<input type=checkbox class=check name="org[]" value="nwdzentratex" id="org-nwdzentratex"
			><label for="org-nwdzentratex"></label>
	<label for="org-nwdzentratex">NWD Zentratex</label>
</div>
<div class=opt>
	<input type=checkbox class=check name="org[]" value="lavantex" id="org-lavantex"
			><label for="org-lavantex"></label>
	<label for="org-lavantex">Lavantex</label>
</div>
<div class=opt>
	<input type=checkbox class=check name="org[]" value="tsa" id="org-tsa"
			><label for="org-tsa"></label>
	<label for="org-tsa">TSA</label>
</div>
<div class=opt>
	<input type=checkbox class=check name="org[]" value="leosystem" id="org-leosystem"
			><label for="org-leosystem"></label>
	<label for="org-leosystem">Leosystem</label>
</div>
<div class=opt>
	<input type=checkbox class=check name="org[]" value="dbl" id="org-dbl"
			><label for="org-dbl"></label>
	<label for="org-dbl">DBL</label>
</div>
<div class=opt>
	<input type=checkbox class=check name="org[]" value="diemietwaesche.de" id="org-diemietwaesche.de"
			><label for="org-diemietwaesche.de"></label>
	<label for="org-diemietwaesche.de">diemietwaesche.de</label>
</div>
</div><div class=clearer></div></div>
<script>
(function(){
var e = document.getElementById('mydataorg');
if (!e)
	return;
var boxes = e.getElementsByTagName('INPUT');
for (var i = 0; i < boxes.length; i++) {
	var box = boxes[i];
	box.onchange = box.onclick = (function(box) { return function() {
		setTimeout(function(){
			if (boxes[0] == box && box.checked) {
				for (var i = 1; i < boxes.length; i++)
					boxes[i].checked = false;
				return;
			}
			var num = 0;
			for (var i = 1; i < boxes.length; i++)
				if (boxes[i].checked)
					num++;
			boxes[0].checked = num == 0;
		}, 100);
		box.blur();
		return true;
	}; })(box);
}
})();
</script>

<p>&nbsp;</p>
<div class=input>
<label class=left>&nbsp;</label>
<div class=opts id=worklabel>
<b>Bitte markieren Sie die Arbeitsweisen, die für Sie
typisch sind:</b><br>&nbsp;</div></div>

<div id=for-type-1>
<div class=input>
<label class=left>&nbsp;</label>
<div class=opts>
<input type=checkbox class=check name="work[]" id="work1-wtabwasserfrisch"
	value="wtabwasserfrisch" checked><label for="work1-wtabwasserfrisch"></label>
	<label for="work1-wtabwasserfrisch"
	>Wärmetauscher Abwasser zu Frischwasser</label><br>
<input type=checkbox class=check name="work[]" id="work1-wrabluftzufrisch"
	value="wrabluftzufrisch"><label for="work1-wrabluftzufrisch"></label>
	<label for="work1-wrabluftzufrisch"
	>Wärmerückgewinnung Abluft zu Frischluft</label><br>
<input type=checkbox class=check name="work[]" id="work1-wrabluftzuwasser"
	value="wrabluftzuwasser"><label for="work1-wrabluftzuwasser"></label>
	<label for="work1-wrabluftzuwasser"
	>Wärmerückgewinnung Abluft zu Wasser</label><br>
<input type=checkbox class=check name="work[]" id="work1-wasserrueck"
	value="wasserrueck" checked><label for="work1-wasserrueck"></label>
	<label for="work1-wasserrueck"
	>Wasserrückgewinnung</label><br>
<input type=checkbox class=check name="work[]" id="work1-wassermehrfach"
	value="wassermehrfach" checked><label for="work1-wassermehrfach"></label>
	<label for="work1-wassermehrfach"
	>Wassermehrfachnutzung</label><br>
<input type=checkbox class=check name="work[]" id="work1-abwassersiebfilter"
	value="abwassersiebfilter"><label for="work1-abwassersiebfilter"></label>
	<label for="work1-abwassersiebfilter"
	>Abwasserbehandlung: Siebfilter</label><br>
<input type=checkbox class=check name="work[]" id="work1-abwasserfaellung"
	value="abwasserfaellung"><label for="work1-abwasserfaellung"></label>
	<label for="work1-abwasserfaellung"
	>Abwasserbehandlung: Fällung/Flockung</label><br>
<input type=checkbox class=check name="work[]" id="work1-abwassermikrofiltration"
	value="abwassermikrofiltration" checked><label for="work1-abwassermikrofiltration"></label>
	<label for="work1-abwassermikrofiltration"
	>Abwasserbehandlung: Mikro-/Ultrafiltration</label><br>
<input type=checkbox class=check name="work[]" id="work1-abwasserneutralis"
	value="abwasserneutralis"><label for="work1-abwasserneutralis"></label>
	<label for="work1-abwasserneutralis"
	>Abwasserbehandlung: Neutralis</label><br>
<input type=checkbox class=check name="work[]" id="work1-abwasserbiologie"
	value="abwasserbiologie"><label for="work1-abwasserbiologie"></label>
	<label for="work1-abwasserbiologie"
	>Abwasserbehandlung: Biologie</label><br>
<input type=checkbox class=check name="work[]" id="work1-dampfkessel"
	value="dampfkessel"><label for="work1-dampfkessel"></label>
	<label for="work1-dampfkessel"
	>Dampfkessel: Abluft-Wärmetausch (ECO)</label><br>
<input type=checkbox class=check name="work[]" id="work1-dampfsystem"
	value="dampfsystem"><label for="work1-dampfsystem"></label>
	<label for="work1-dampfsystem"
	>Dampf-System: Brüdendampf-Nutzung</label><br>
</div><br>
<label class=left>sonstige Abwasserbehandlung</label>
<input type=text class=text name=abwasserandere value=""><br>
</div>
</div>

<div id=for-type-2>
<div class=input>
<label class=left>&nbsp;</label>
<div class=opts>
<input type=checkbox class=check name="work[]" id="work2-kontakt"
	value="kontakt"><label for="work2-kontakt"></label>
	<label for="work2-kontakt"
	>Kontaktwasseraufbereitung</label><br>
<input type=checkbox class=check name="work[]" id="work2-wasserrueck"
	value="wasserrueck" checked><label for="work2-wasserrueck"></label>
	<label for="work2-wasserrueck"
	>Wasserrückgewinnung</label><br>
<input type=checkbox class=check name="work[]" id="work2-kuehl"
	value="kuehl"><label for="work2-kuehl"></label>
	<label for="work2-kuehl"
	>Kühlwasserrückgewinnung</label><br>
</div>
</div>
</div>

<div id=for-type-3>
<div class=input>
<label class=left>&nbsp;</label>
<div class=opts>
<input type=checkbox class=check name="work[]" id="work3-kontakt"
	value="kontakt"><label for="work3-kontakt"></label>
	<label for="work3-kontakt"
	>Kontaktwasseraufbereitung</label><br>
<input type=checkbox class=check name="work[]" id="work3-wtabwasserfrisch"
	value="wtabwasserfrisch" checked><label for="work3-wtabwasserfrisch"></label>
	<label for="work3-wtabwasserfrisch"
	>Wärmetauscher Abwasser zu Frischwasser</label><br>
<input type=checkbox class=check name="work[]" id="work3-wrabluftzufwasser"
	value="wrabluftzufwasser"><label for="work3-wrabluftzufwasser"></label>
	<label for="work3-wrabluftzufwasser"
	>Wärmerückgewinnung Abluft zu Frischwasser</label><br>
<input type=checkbox class=check name="work[]" id="work3-wrabluftzufluft"
	value="wrabluftzufluft"><label for="work3-wrabluftzufluft"></label>
	<label for="work3-wrabluftzufluft"
	>Wärmerückgewinnung Abluft zu Frischluft</label><br>
<input type=checkbox class=check name="work[]" id="work3-wasserrueck"
	value="wasserrueck" checked><label for="work3-wasserrueck"></label>
	<label for="work3-wasserrueck"
	>Wasserrückgewinnung</label><br>
<input type=checkbox class=check name="work[]" id="work3-kuehl"
	value="kuehl"><label for="work3-kuehl"></label>
	<label for="work3-kuehl"
	>Kühlwasserrückgewinnung</label><br>
</div>
</div>
</div>

<script>
(function(){
function upddisplay() {
	var found = false;
	for (var i = 1; i <= 3; i++) {
		var r = document.getElementById("type-" + i);
		var e = document.getElementById("for-type-" + i);
		if (!r || !e)
			continue;
		if (r.checked) {
			e.style.display = '';
			found = true;
		} else
			e.style.display = 'none';
	}
	e = document.getElementById("worklabel");
	if (e)
		e.style.display = found ? '' : 'none';
}

function setonchange(r) {
	var old = r.onchange;
	r.onchange = function() {
		if (old)
			old();
		upddisplay();
	};
}

for (var i = 1; i <= 3; i++) {
	var r = document.getElementById("type-" + i);
	if (!r)
		continue;
	setonchange(r);
}

upddisplay();
})();
</script>

</div>

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

</div>

<div class=clearer></div>
<p>&nbsp;</p>

<div class=buttons>
<div class=right>
<input type="submit" name="save" value="speichern">
</div>
<div class=left>
<input type="submit" name="back" value="abbrechen">
</div>
<div class=clearer></div>
</div>
</form>

<?php require_once('footer.php'); ?>