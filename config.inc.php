<?php
/** 
 * Addon: 	cleverreach
 * @author 	Norbert Micheel, based heavily on a module for joomla by Martin Mlinski | Matic-Tec.de
 * http://lautundschoen.de
 */


$mypage = 'lus_cleverreach'; // only for this file

$basedir = dirname(__FILE__);

if ($REX['REDAXO'])
{
	$I18N->appendFile($REX['INCLUDE_PATH'].'/addons/'.$mypage.'/lang/');
}

//$REX['ADDON']['rxid'][$mypage] = "b_1";
$REX['ADDON']['page'][$mypage] = $mypage;
$REX['ADDON']['name'][$mypage] = 'cleverreach Anbindung';
$REX['ADDON']['perm'][$mypage] = 'lus_cleverreach[]';
$REX['ADDON']['version'][$mypage] = '0.3';
$REX['ADDON']['author'][$mypage] = 'Norbert Micheel';
$REX['ADDON']['supportpage'][$mypage] = 'lautundschoen.de';
$REX['ADDON']['path'][$mypage] = $REX['INCLUDE_PATH'].'/addons/'.$mypage;


$REX['PERM'][] = 'lus_cleverreach[]';

// add lang file
if ($REX['REDAXO']) {
    $I18N->appendFile($REX['INCLUDE_PATH'] . "/addons/$mypage/lang/");
}


$REX['ADDON']['xform']['classpaths']['action'][] = $REX["INCLUDE_PATH"]."/addons/$mypage/xform/action/";

// includes
require($REX['INCLUDE_PATH'] . "/addons/$mypage/classes/class.cleverreach_api_helper.inc.php");
require($REX['INCLUDE_PATH'] . "/addons/$mypage/classes/class.rex_lus_cleverreach_utils.inc.php");

// default settings (user settings are saved in data dir!)
/*$REX['ADDON']['lus_cleverreach']['settings'] = array(
    'apikey' => '',
    'groupid' => 0,
    'formid' => 0,
    'source' => '',
    'privacy' => '',
    'privacyitem' => '',
    'infotext' => ''
);*/

// overwrite default settings with user settings
rex_lus_cleverreach_utils::includeSettingsFile();


?>