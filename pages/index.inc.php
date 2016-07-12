<?php

$page    = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$chapter = rex_request('chapter', 'string');
$func    = rex_request('func', 'string');

$myroot  = $REX['INCLUDE_PATH'].'/addons/' . $page;

$header = array('<link rel="stylesheet" type="text/css" href="../files/addons/' . $page . '/backend.css" media="screen, projection, print" />');

require $REX['INCLUDE_PATH'] . '/layout/top.php';

rex_title($REX['ADDON']['name'][$page] . ' <span style="font-size:14px; color:silver;">' . $REX['ADDON']['version'][$page] . '</span>');

if (!$subpage) {
	$subpage = 'settings';
}

require $REX['INCLUDE_PATH'] . '/addons/'.$page.'/pages/'.$subpage.'.inc.php';

require $REX['INCLUDE_PATH'] . '/layout/bottom.php';
