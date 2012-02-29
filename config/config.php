<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * @copyright 	4ward.media 2012 <http://www.4wardmedia.de>
 * @author 		Christoph Wiechert <wio@psitrax.de>
 * @license    	LGPL
 * @package 	redirect4ward
 * @filesource
 */

array_insert($GLOBALS['BE_MOD']['system'],2,array(
	'redirect4ward' => array(
		'tables'     => array('tl_redirect4ward'),
		'icon' => 'system/modules/redirect4ward/html/icon.png' 
	)
));

$GLOBALS['TL_PTY']['error_404'] = 'PageError404_Redirect4ward';

?>