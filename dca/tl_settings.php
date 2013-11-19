<?php

/**
 * @copyright 	4ward.media 2013 <http://www.4wardmedia.de>
 * @author 		Christoph Wiechert <wio@psitrax.de>
 * @license    	LGPL
 * @package 	redirect4ward
 * @filesource
 */

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{redirect4ward_legend:hide},redirect4wardKillQueryStr,redirect4wardAvoid404';

if (in_array('htaccess', $this->Config->getActiveModules()))
{
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


$GLOBALS['TL_DCA']['tl_settings']['fields']['redirect4wardAvoid404'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_settings']['redirect4wardAvoid404'],
	'inputType' => 'checkbox',
	'eval'      => array('tl_class' => 'm12 w50')
);
