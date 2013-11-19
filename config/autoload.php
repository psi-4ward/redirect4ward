<?php

/**
 * @copyright    4ward.media 2013 <http://www.4wardmedia.de>
 * @author        Christoph Wiechert <wio@psitrax.de>
 * @license        LGPL
 * @package    redirect4ward
 * @filesource
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'HtaccessRedirect4ward'      => 'system/modules/redirect4ward/HtaccessRedirect4ward.php',
	'PageError404_Redirect4ward' => 'system/modules/redirect4ward/PageError404_Redirect4ward.php',
));
