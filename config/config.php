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

$GLOBALS['TL_HOOKS']['getPageIdFromUrl'][] = array('Redirect4ward', 'getPageIdFromUrl');

array_insert($GLOBALS['BE_MOD']['system'],2,array(
	'redirect4ward' => array(
		'tables'     => array('tl_redirect4ward'),
		'icon' => 'system/modules/redirect4ward/html/icon.png' 
	)
));

?>