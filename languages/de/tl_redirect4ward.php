<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * @copyright 	4ward.media 2012 <http://www.4wardmedia.de>
 * @author 		Christoph Wiechert <wio@psitrax.de>
 * @license    	LGPL
 * @package 	redirect4ward
 * @filesource
 */

$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpToType'][0]	= "Zieltyp";
$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpToType'][1]	= "Soll zu einer internen oder externen Seite umgeleitet werden?";

$GLOBALS['TL_LANG']['tl_redirect4ward']['url'][0]		= "URL";
$GLOBALS['TL_LANG']['tl_redirect4ward']['url'][1]		= "Die URL der Weiterleitung, ohne Domain. Z.B.: alteseite/index.html";

$GLOBALS['TL_LANG']['tl_redirect4ward']['host'][0]		= "Host";
$GLOBALS['TL_LANG']['tl_redirect4ward']['host'][1]		= "Die Weiterleitung betrifft nur den angegebenen Hostname (DNS).";

$GLOBALS['TL_LANG']['tl_redirect4ward']['rgxp'][0]	= "Regulärer Ausdruck";
$GLOBALS['TL_LANG']['tl_redirect4ward']['rgxp'][1]	= "Interpretiert die URL als REGEXP. Parameter wie $1 können in der Ziel-URL verwendet werden.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpTo'][0]	= "Umleitungsziel";
$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpTo'][1]	= "Zu dieser internen Website wird umgeleitet.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['parameters'][0]	= "Parameter";
$GLOBALS['TL_LANG']['tl_redirect4ward']['parameters'][1]	= "Hier können Sie zusätzliche Parameter definieren, welche an die URL angehängt werden.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['externalUrl'][0]		= "Externe URL";
$GLOBALS['TL_LANG']['tl_redirect4ward']['externalUrl'][1]		= "Die URL der Zeilseite. Diese kann auch ohne Domain angegeben werden.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['type'][0]		= "Typ";
$GLOBALS['TL_LANG']['tl_redirect4ward']['type'][1]		= "Legt fest, ob die Umleitung temporär oder permanent ist.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['priority'][0]	= "Priorität";
$GLOBALS['TL_LANG']['tl_redirect4ward']['priority'][1]	= "Wählen Sie hier eine Priorität, je kleiner um so höher ist die Priorität der Regel.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['published'][0]	= "Aktiviert";
$GLOBALS['TL_LANG']['tl_redirect4ward']['published'][1]	= "Hier kann die Weiterleitung deaktiviert werden.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['language']     = "Sprachen";

$GLOBALS['TL_LANG']['tl_redirect4ward']['everyHost'] = 'jeder Host';
$GLOBALS['TL_LANG']['tl_content']['tl_redirect4ward']['tl_redirect4wardTypes']['intern']	= 'Interne Weiterleitung';
$GLOBALS['TL_LANG']['tl_content']['tl_redirect4ward']['tl_redirect4wardTypes']['intern_ml'] = 'Interne Weiterleitung - Mehrsprachig';
$GLOBALS['TL_LANG']['tl_content']['tl_redirect4ward']['tl_redirect4wardTypes']['extern']	= 'Externe Weiterleitung';

$GLOBALS['TL_LANG']['tl_redirect4ward']['typeOptions'] = array(
	'301'	=> 'Permanente (301)',
	'307'	=> 'Temporär (307)',
	
);


$GLOBALS['TL_LANG']['tl_redirect4ward']['new']    = array('Neue Weiterleitung', 'Eine neue Weiterleitung anlegen');

$GLOBALS['TL_LANG']['tl_redirect4ward']['type_legend'] = 'Weiterleitungs-Typ';
$GLOBALS['TL_LANG']['tl_redirect4ward']['target_legend'] = 'Ziel';
$GLOBALS['TL_LANG']['tl_redirect4ward']['expert_legend'] = 'Weitere Einstellungen';
$GLOBALS['TL_LANG']['tl_redirect4ward']['publish_legend'] = 'Veröffentlichung';


?>