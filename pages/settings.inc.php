<?php

$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$func = rex_request('func', 'string');

$apikey = rex_request('apikey', 'string');
$groupid = rex_request('groupid', 'string');
$formid = rex_request('formid', 'string');
$source = rex_request('source', 'string');

if (empty($apikey) ) { $apikey = $REX['ADDON']['lus_cleverreach']['settings']['apikey']; }
if (empty($groupid) ) { $groupid = $REX['ADDON']['lus_cleverreach']['settings']['groupid']; }
if (empty($formid) ) { $formid = $REX['ADDON']['lus_cleverreach']['settings']['formid']; }
if (empty($source) ) { $source = $REX['ADDON']['lus_cleverreach']['settings']['source']; }


$htmlgroup = array();
$htmlform = array();
$selectgroupid = new rex_select();
$selectformid = new rex_select();


if (empty($apikey)) {
	$htmlgroup[] = $I18N->msg('lus_cleverreach_select_apikey');
} else {
	try {
		$api = new CleverreachAPI($apikey);
		$result = $api->getGroupList();
		$selectgroupid->setSize(1);
		$selectgroupid->setName('groupid');
		if ( !empty($groupid) ) { $selectgroupid->setSelected($groupid); }

		if ($result != false && $result->status == "SUCCESS") {
			$selectgroupid->addOption($I18N->msg('lus_cleverreach_select_groupid'),-1);
			foreach ($result->data as $dataset) {
				$selectgroupid->addOption( $dataset->name, $dataset->id);
			}
			$htmlgroup[] = $selectgroupid->get();
		} else {
			$htmlgroup[] = $I18N->msg('lus_cleverreach_groupid_failure');
		}

	} catch (Exception $e) {
		$htmlgroup[] = $I18N->msg('lus_cleverreach_api_failure');
	}

}
if (empty($groupid)) {
	$htmlform[] = $I18N->msg('lus_cleverreach_select_groupid');
} else {
	if (!empty($apikey)) {
		try {
			$api = new CleverreachAPI($apikey);
			$result = $api->getFormsList($groupid);
			$selectformid->setSize(1);
			$selectformid->setName('formid');
			if ( !empty($formid) ) {$selectformid->setSelected($formid); }

			if ($result != false && $result->status == "SUCCESS") {
				$selectformid->addOption($I18N->msg('lus_cleverreach_select_formid'), -1);
				foreach ($result->data as $dataset) {
					$selectformid->addOption($dataset->name, $dataset->id);
				}
				$htmlform[] = $selectformid->get();
			} else {
				$htmlform[] = $I18N->msg('lus_cleverreach_formid_failure');
			}

		} catch (Exception $e) {
			$htmlform[] = $I18N->msg('lus_cleverreach_api_failure');
		}
	}
}
// save settings
if ($func == 'update') {
	$REX['ADDON']['lus_cleverreach']['settings']['apikey'] = $apikey;
	$REX['ADDON']['lus_cleverreach']['settings']['groupid'] = $groupid;
	$REX['ADDON']['lus_cleverreach']['settings']['formid'] = $formid;
	$REX['ADDON']['lus_cleverreach']['settings']['source'] = $source;


	rex_lus_cleverreach_utils::updateSettingsFile(true);
}


?>

<div class="rex-addon-output">

<h2 class="rex-hl2"><?php echo $I18N->msg('lus_cleverreach_subpage_config') ; ?></h2>
<div class="rex-area-content">
<p>
Dieses Addon ermöglicht es E-Mail-Adressen mit dem E-Mail-Versand-Anbieter <a href="http://www.cleverreach.de/frontend/?rk=12968pvmjlnca" target="_blank">cleverreach</a> zu synchronisieren.
Dazu benutzt man ein XFORM-Formular, in das man das von diesem Addon bereitgestellte Action-Element "cr_recipient" einsetzt. Das Element hat die folgende XFORM Syntax:
	<br /><br />
	<pre style="font-size: 1.2em;">action|cr_recipient|emailfield|0/1/actionfield</pre>
	<br />
</p>
<p>Parameter:<br />
	<b>emailfeld</b> - gibt das Feld im Formular an, das die E-Mail-Adresse enthält.<br />
	<b>0/1/actionfeld</b>	- Hier wird die durchzuführende Aktion gewählt ( 0 = Abmelden, 1 = Anmelden) bzw. ein Feld im Formular angegeben, das die entsprechenden Werte liefert. Z.B. ein Radio Feld zur Auswahl durch den Benutzer.<br />
</p>
	<p>
		<br /><br />
		Hier auf dieser Seite werden Daten hinterlegt und Einstellungen gemacht, die die Schnittstelle zu cleverreach benötigt.
		Das sind:
	</p>
		<ol><li>API - Key (Schlüssel)</li>
		<li>Eine Adressengruppe</li>
		<li>Ein An- / Abmeldeformular</li>
		<li>Ein Text, an dem man später erkennen kann, dass die Adressen über diese Website eingetragen wurden (optional)</li>
	</ol>
	<p>
		Nach Eingabe des API-Schlüssels ( den Sie bei <a href="http://www.cleverreach.de/frontend/?rk=12968pvmjlnca" target="_blank">cleverreach</a> unter "Account --> Extras --> SOAP API mit Druck auf den Knopf
		"API Key erstellen" erzeugen können ) und einem Klick auf "aktualisieren", erscheint im Feld darunter eine Liste mit allen bei cleverreach angelegten
		Empfängergruppen.
	</p>
	<p>
		Wir diese Auswahl der Grupper wiederum gespeichert, erscheint im Feld darunter eine Liste mit allen bei cleverreach angelegten
		An- / Abmeldeformularen. Dies ist notwendig, da das Formular die Opt-in E-Mail erzeugt.
	</p>

	</div>
</div>
<div class="rex-addon-output">
	<h2 class="rex-hl2"><?php echo $I18N->msg('lus_cleverreach_subpage_config2') ; ?></h2>
	<div class="rex-area-content">
		<div class="rex-form">
			<form action="index.php" method="post">
				<input type="hidden" name="page" value="lus_cleverreach" />
				<input type="hidden" name="subpage" value="" />
				<input type="hidden" name="func" value="update" />
				<fieldset class="rex-form-col-1">
					<div class="rex-form-wrapper">
						<div class="rex-form-row">
						</div>
						<div class="rex-form-row rex-form-element">
							<p class="rex-form-text">
								<label for="apikey"><?php echo $I18N->msg('lus_cleverreach_apikey'); ?></label>
								<input class="rex-form-text" type="text" id="apikey" name="apikey" value="<?php echo htmlspecialchars($REX['ADDON']['lus_cleverreach']['settings']['apikey']); ?>" />
							</p>
						</div>
						<div class="rex-form-row rex-form-element">
							<p class="rex-form-text">
								<label for="groupid"><?php echo $I18N->msg('lus_cleverreach_groupid'); ?></label>
								<?php echo implode('<br />',$htmlgroup); ?>
							</p>
						</div>
						<div class="rex-form-row rex-form-element">
							<p class="rex-form-text">
								<label for="formid"><?php echo $I18N->msg('lus_cleverreach_formid'); ?></label>
								<?php echo implode("\n",$htmlform); ?>
							</p>
						</div>
						<div class="rex-form-row rex-form-element">
							<p class="rex-form-text">
								<label for="source"><?php echo $I18N->msg('lus_cleverreach_source'); ?></label>
								<input class="rex-form-text" type="text" id="source" name="source" value="<?php echo htmlspecialchars($REX['ADDON']['lus_cleverreach']['settings']['source']); ?>" />
							</p>
						</div>
						<div class="rex-form-row rex-form-element">
							<p class="rex-form-submit">
								<input type="submit" class="rex-form-submit" name="sendit" value="<?php echo $I18N->msg('update'); ?>" />
							</p>
						</div>


					</div>
				</fieldset>
			</form>
		</div>
	</div>

</div>

<style type="text/css">
	a.extern {
		background: transparent url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAA8CAYAAACq76C9AAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAFFSURBVHjaYtTpO/CfAQcACCAmBjwAIIAY//9HaNTtP4hiCkAAMeGSAAGAAGJCl7hcaM8IYwMEEBMuCRAACCAmXBIgABBAKA5CBwABhNcrAAGEVxIggPBKAgQQXkmAAMIrCRBAeCUBAgivJEAA4ZUECCC8kgABhFcSIIDwSgIEEF5JgADCKwkQQHglAQIIryRAAOGVBAggvJIAAYRXEiCA8EoCBBBeSYAAwisJEEB4JQECiAVbNoABgADCqxMggPDmMoAAwpvLAAIIby4DCCC8uQwggPDmMoAAwpvLAAIIr1cAAgivJEAA4ZUECCC8kgABhFcSIIDwSgIEEF5JgADCKwkQQHglAQIIryRAAOGVBAggvJIAAYRXEiCA8EoCBBBeSYAAwisJEEB4JQECCK8kQADhlQQIILySAAGEVxIggPBKAgQYAARTLlfrU5G2AAAAAElFTkSuQmCC) no-repeat right 2px;
		padding-right: 10px;
	}

	#css-hint {
		display: none;
		margin-left: 53px;
		margin-top: 5px;
	}

	div.rex-form-row p.rex-form-label-right input.rex-form-checkbox {
		margin-left: 20px;
	}

	div.rex-form div.rex-form-row p input.rex-form-submit {
		margin-left: 0;
		margin-right: 5px;
		float: right;
	}
</style>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$( "#nojavascriptmethod").change(function() {
			if ($(this).is(':checked')) {
				$('#css-hint').css('display', 'block');
			} else {
				$('#css-hint').hide();
			}
		});

		$( "#nojavascriptmethod").change();
	});
</script>
