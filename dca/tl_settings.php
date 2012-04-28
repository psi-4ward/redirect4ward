<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * @copyright 	4ward.media 2012 <http://www.4wardmedia.de>
 * @author 		Christoph Wiechert <wio@psitrax.de>
 * @license    	LGPL
 * @package 	redirect4ward
 * @filesource
 */

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{redirect4ward_legend:hide},redirect4wardKillQueryStr';
if (in_array('htaccess', $this->getActiveModules())) {
	$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ',redirect4ward_use_htaccess';
}


$GLOBALS['TL_DCA']['tl_settings']['fields']['redirect4wardKillQueryStr'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['redirect4wardKillQueryStr'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'m12 w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['redirect4ward_use_htaccess'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['redirect4ward_use_htaccess'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'m12 w50')
);

?>
