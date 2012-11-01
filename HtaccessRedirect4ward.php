<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * htaccess Generator
 * Copyright (C) 2011 Tristan Lins
 *
 * Extension for:
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  InfinitySoft 2011
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    htaccess Generator
 * @license    LGPL
 * @filesource
 */


/**
 * Class HtaccessRedirect4ward
 *
 * @copyright  Tristan Lins 2011
 * @author     Tristan Lins <info@infinitysoft.de>
 * @package    htaccess Generator
 */
class HtaccessRedirect4ward extends Controller implements HtaccessSubmodule
{
	/**
	 * Generate this sub module code.
	 *
	 * @return string
	 */
	public function generateSubmodule()
	{
		$GLOBALS['TL_CONFIG']['forceAbsoluteDomainLink'] = true;

		$this->import('Database');

		$blnNewApache = preg_match('#apache/(\d+(\.\d+)*)#i', $_SERVER['SERVER_SOFTWARE'], $arrMatch) && version_compare($arrMatch[1], '2.4', '>=');

		$strBuffer = '';

		$objRedirect = $this->Database
			->query('SELECT * FROM tl_redirect4ward WHERE published=\'1\' ORDER BY url, priority');
		while ($objRedirect->next()) {
			// get the target url...
			switch ($objRedirect->jumpToType)
			{
				// ...for internal redirects
				case 'Intern':
					$objPage = $this->Database
						->prepare('SELECT * FROM tl_page WHERE id=?')
						->execute($objRedirect->jumpTo);
					if (!$objPage->next()) {
						continue;
					}
					$strTarget = $this->generateFrontendUrl($objPage->row());
					break;

				// ...for external redirects
				case 'Extern':
					$strTarget = $objRedirect->externalUrl;
					break;

				// ...or continue with next
				default:
					continue 2;
			}

			// get the source url
			$strUrl = $objRedirect->rgxp ? $objRedirect->url : preg_quote($objRedirect->url);

			// extract query string from source url
			if (preg_match('#^(.*)\\\\\?(.*)$#', $strUrl, $arrMatch)) {
				$strUrl = $arrMatch[1];
				$strQuery = $arrMatch[2];
			}
			else {
				$strQuery = '';
			}

			// discard query string for apache <=2.3
			if (!$blnNewApache &&
				isset($GLOBALS['TL_CONFIG']['redirect4wardKillQueryStr']) &&
				$GLOBALS['TL_CONFIG']['redirect4wardKillQueryStr']) {
				$strTarget .= '?';
			}

			// check host domain
			if ($objRedirect->host) {
				$strBuffer .= 'RewriteCond %{HTTP_HOST} ^(www\.)?' . preg_quote($objRedirect->host) . ' [NC]' . "\n";
			}
			// check query string
			if ($strQuery) {
				$strBuffer .= 'RewriteCond %{QUERY_STRING} ^' . $strQuery . "\n";
			}
			// write the rewrite rule
			$strBuffer .= 'RewriteRule ';
			// the source url
			$strBuffer .= '^' . $strUrl . ' ';
			// the target url
			$strBuffer .= $strTarget;
			// add modifiers
			$strBuffer .= ' [L,R=' . $objRedirect->type . '';
			// append query string
			if (!isset($GLOBALS['TL_CONFIG']['redirect4wardKillQueryStr']) || !$GLOBALS['TL_CONFIG']['redirect4wardKillQueryStr']) {
				$strBuffer .= ',QSA';
			}
			// discard query string for apache 2.4+
			else if ($blnNewApache) {
				$strBuffer .= ',QSD';
			}

			$strBuffer .= "]\n\n";
		}

		return $strBuffer;
	}
}
