<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005-2009 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright 4ward.media 2010
 * @author    Christoph Wiechert <christoph.wiechert@4wardmedia.de>
 * @package   redirect4ward
 * @filesource
 */

$GLOBALS['TL_LANG']['tl_redirect4ward']['url'][0]		= "URL";
$GLOBALS['TL_LANG']['tl_redirect4ward']['url'][1]		= "Die URL der Weiterleitung, ohne Domain. Z.B.: alteseite/index.html";

$GLOBALS['TL_LANG']['tl_redirect4ward']['host'][0]		= "Host";
$GLOBALS['TL_LANG']['tl_redirect4ward']['host'][1]		= "Die Weiterleitung betrifft nur den angegebenen Hostname (DNS).";

$GLOBALS['TL_LANG']['tl_redirect4ward']['externalUrl'][0]		= "Externe URL";
$GLOBALS['TL_LANG']['tl_redirect4ward']['externalUrl'][1]		= "Die URL der Zeilseite. Diese kann auch ohne Domain angegeben werden.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpTo'][0]	= "Umleitungsziel";
$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpTo'][1]	= "Zu dieser internen Website wird umgeleitet.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpToType'][0]	= "Zieltyp";
$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpToType'][1]	= "Soll zu einer internen oder externen Seite umgeleitet werden?";

$GLOBALS['TL_LANG']['tl_redirect4ward']['type'][0]		= "Typ";
$GLOBALS['TL_LANG']['tl_redirect4ward']['type'][1]		= "Legt fest, ob die Umleitung temporär oder permanent ist.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['published'][0]	= "Aktiviert";
$GLOBALS['TL_LANG']['tl_redirect4ward']['published'][1]	= "Hier kann die Weiterleitung deaktiviert werden.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['rgxp'][0]	= "Regulärer Ausdruck";
$GLOBALS['TL_LANG']['tl_redirect4ward']['rgxp'][1]	= "Interpretiert die URL als REGEXP. Parameter wie $1 können in der Ziel-URL verwendet werden.";


$GLOBALS['TL_LANG']['tl_redirect4ward']['everyHost'] = 'jeder Host';
$GLOBALS['TL_LANG']['tl_content']['tl_redirect4ward']['tl_redirect4wardTypes']['intern'] = 'Interne Weiterleitung';
$GLOBALS['TL_LANG']['tl_content']['tl_redirect4ward']['tl_redirect4wardTypes']['extern'] = 'Externe Weiterleitung';

$GLOBALS['TL_LANG']['tl_redirect4ward']['typeOptions'] = array(
	'301'	=> 'Permanente (301)',
	'307'	=> 'Temporär (307)',
	
);


$GLOBALS['TL_LANG']['tl_redirect4ward']['new']    = array('Neue Weiterleitung', 'Eine neue Weiterleitung anlegen');

$GLOBALS['TL_LANG']['tl_redirect4ward']['type_legend'] = 'Weiterleitungs-Typ';
$GLOBALS['TL_LANG']['tl_redirect4ward']['target_legend'] = 'Ziel';
$GLOBALS['TL_LANG']['tl_redirect4ward']['expert_legend'] = 'Weitere Einstellungen';


?>