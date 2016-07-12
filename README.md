# lus_rex4_cleverreach
REDAXO 4 Addon für cleverreach Anbindung

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