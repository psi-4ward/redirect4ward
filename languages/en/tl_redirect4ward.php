<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * @copyright 	4ward.media 2012 <http://www.4wardmedia.de>
 * @author 		Christoph Wiechert <wio@psitrax.de>
 * @license    	LGPL
 * @package 	redirect4ward
 * @filesource
 */

$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpToType'][0]	= "Targettype";
$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpToType'][1]	= "Choose between an internal or external redirection.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['url'][0]		= "URL";
$GLOBALS['TL_LANG']['tl_redirect4ward']['url'][1]		= "The URL of the redirect without domain. e.g.: oldpage/index.html";

$GLOBALS['TL_LANG']['tl_redirect4ward']['host'][0]		= "Host";
$GLOBALS['TL_LANG']['tl_redirect4ward']['host'][1]		= "The redirect matches only for the given host (dns).";

$GLOBALS['TL_LANG']['tl_redirect4ward']['rgxp'][0]	= "regular expression";
$GLOBALS['TL_LANG']['tl_redirect4ward']['rgxp'][1]	= "Use URL as REGEXP. You can use parameters like $1 in the target url.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpTo'][0]	= "Redirect-target";
$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpTo'][1]	= "The request redirects to this website.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['parameters'][0]	= "Parameters";
$GLOBALS['TL_LANG']['tl_redirect4ward']['parameters'][1]	= "Additional parameters for the url.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['externalUrl'][0]		= "External URL";
$GLOBALS['TL_LANG']['tl_redirect4ward']['externalUrl'][1]		= "The URL of the target-website. You can enter one without an domain.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['type'][0]		= "Redirecttype";
$GLOBALS['TL_LANG']['tl_redirect4ward']['type'][1]		= "Choose between an permanent or temporaray redirection.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['priority'][0]	= "Priority";
$GLOBALS['TL_LANG']['tl_redirect4ward']['priority'][1]	= "Choose priority for this rule. Smaller values are prefered.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['published'][0]	= "Active";
$GLOBALS['TL_LANG']['tl_redirect4ward']['published'][1]	= "Here you can disable the redirection.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['language']     = "Languages";

$GLOBALS['TL_LANG']['tl_redirect4ward']['everyHost'] = 'every host';
$GLOBALS['TL_LANG']['tl_content']['tl_redirect4ward']['tl_redirect4wardTypes']['intern']	= 'Internal redirection';
$GLOBALS['TL_LANG']['tl_content']['tl_redirect4ward']['tl_redirect4wardTypes']['intern_ml'] = 'Internal redirection - Multilingual';
$GLOBALS['TL_LANG']['tl_content']['tl_redirect4ward']['tl_redirect4wardTypes']['extern']	= 'External redirection';

$GLOBALS['TL_LANG']['tl_redirect4ward']['typeOptions'] = array(
	'301'	=> 'Permanent (301)',
	'307'	=> 'Temporaray (307)',
	
);


$GLOBALS['TL_LANG']['tl_redirect4ward']['new']    = array('New redirection', 'Creates a new redirection.');

$GLOBALS['TL_LANG']['tl_redirect4ward']['importSitemap'][0]	= "Import sitemap";
$GLOBALS['TL_LANG']['tl_redirect4ward']['importSitemap'][1]	= "Import sitemap.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['importLogs'][0]	= "Import 404 logs";
$GLOBALS['TL_LANG']['tl_redirect4ward']['importLogs'][1]	= "Import 404 logs.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['type_legend'] = 'Redirect-type';
$GLOBALS['TL_LANG']['tl_redirect4ward']['target_legend'] = 'Target';
$GLOBALS['TL_LANG']['tl_redirect4ward']['expert_legend'] = 'Config';
$GLOBALS['TL_LANG']['tl_redirect4ward']['publish_legend'] = 'Publish settings';

$GLOBALS['TL_LANG']['tl_redirect4ward']['source'][0] = "Sitemap URL";
$GLOBALS['TL_LANG']['tl_redirect4ward']['source'][1] = "Sitemap URL.";

$GLOBALS['TL_LANG']['tl_redirect4ward']['addLogMessage'] = 'Add %d new redirections from the log.';

$GLOBALS['TL_LANG']['tl_redirect4ward']['addSitemapMessage'] = 'Add %d new redirection from the sitemap (<a href="%s">%s</a>).';
$GLOBALS['TL_LANG']['tl_redirect4ward']['addSitemapErrorMessage'] = 'Can not read sitemap (<a href="%s">%s</a>).';

$GLOBALS['TL_LANG']['tl_redirect4ward']['everyHost'] = 'jeder Host';

$GLOBALS['TL_LANG']['tl_redirect4ward']['sitemap_source_label'] = 'Sitemap URL';
$GLOBALS['TL_LANG']['tl_redirect4ward']['sitemap_headline'] = 'Import sitemap';
