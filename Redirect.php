<?php if(!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
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
 * @copyright  	mediabakery
 * @author     	Sebastian Tilch <http://www.mediabakery.de>
 * @license    	LGPL
 * @package 		Redirect4ward
 * @filesource
 */

class Redirect extends Backend
{

	private $arrHosts;

	/**
	 * Import a sitemap
	 */
	public function importSitemap()
	{
		$this->loadLanguageFile('tl_redirect4ward');

		if($this->Input->post('FORM_SUBMIT') == 'tl_import_sitemap')
		{
			$this->import('tl_redirect4ward');
			$this->import('Request');

			$this->arrHosts = $this->tl_redirect4ward->getHosts();
			$strSource = $this->Input->post('source', true);
			if(!strlen($strSource))
			{
				$this->addErrorMessage(sprintf($GLOBALS['TL_LANG']['tl_redirect4ward']['addSitemapErrorMessage'], $strSource, $strSource));
				$this->reload();
			}
			$intCounter = 0;

			$objReq = new Request();
			$objReq->send($strSource);

			if(!$objReq->hasError())
			{
				$objXml = simplexml_load_string($objReq->response);
				if(!$objXml)
				{
					$this->addErrorMessage(sprintf($GLOBALS['TL_LANG']['tl_redirect4ward']['addSitemapErrorMessage'], $strSource, $strSource));
					$this->reload();
				}
				foreach($objXml as $objUrl)
				{
					if($this->addLocation($objUrl->loc))
						$intCounter++;
				}
			}
			else
			{
				$this->addErrorMessage(sprintf($GLOBALS['TL_LANG']['tl_redirect4ward']['addSitemapErrorMessage'], $strSource, $strSource));
				$this->reload();
			}
			$this->addInfoMessage(sprintf($GLOBALS['TL_LANG']['tl_redirect4ward']['addSitemapMessage'], $intCounter, $strSource, $strSource));
		}

		$objField = new TextField($this->prepareForWidget($GLOBALS['TL_DCA']['tl_redirect4ward']['fields']['source'], 'source', null, 'source'));

		// Return the form
		return '
<div id="tl_buttons">
<a href="' . ampersand(str_replace('&key=importSitemap', '', $this->Environment->request)) . '" class="header_back" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['backBT']) . '" accesskey="b">' . $GLOBALS['TL_LANG']['MSC']['backBT'] . '</a>
</div>

<h2 class="sub_headline">' . $GLOBALS['TL_LANG']['tl_redirect4ward']['importSitemap'][1] . '</h2>
' . $this->getMessages() . '
<form action="' . ampersand($this->Environment->request, true) . '" id="tl_import_sitemap" class="tl_form" method="post">
<div class="tl_formbody_edit">
<input type="hidden" name="FORM_SUBMIT" value="tl_import_sitemap">
<input type="hidden" name="REQUEST_TOKEN" value="' . REQUEST_TOKEN . '">

<div class="tl_tbox block">
  <h3><label for="source">' . $GLOBALS['TL_LANG']['tl_redirect4ward']['source'][0] . '</label></h3>' . $objField->generate() . (strlen($GLOBALS['TL_LANG']['tl_redirect4ward']['source'][1]) ? '
  <p class="tl_help tl_tip">' . $GLOBALS['TL_LANG']['tl_redirect4ward']['source'][1] . '</p>' : '') . '
</div>

</div>

<div class="tl_formbody_submit">

<div class="tl_submit_container">
  <input type="submit" name="save" id="save" class="tl_submit" accesskey="s" value="' . specialchars($GLOBALS['TL_LANG']['tl_redirect4ward']['importSitemap'][0]) . '">
</div>

</div>
</form>';
	}

	/**
	 * Import from logs
	 */
	public function importLogs()
	{
		$this->import('tl_redirect4ward');
		$this->import('Request');

		$this->arrHosts = $this->tl_redirect4ward->getHosts();
		$intStart = time() - 3600;

		$objLogs = $this->Database->prepare("SELECT text FROM tl_log WHERE tstamp > ? AND func = 'PageError404 generate()'")->execute($intStart);
		$intCounter = 0;
		while($objLogs->next())
		{
			preg_match('/\((.*)\)/', $objLogs->text, $arrUrls);
			if($this->addLocation($arrUrls[1]))
				$intCounter++;
		}
		$this->addInfoMessage(sprintf($GLOBALS['TL_LANG']['tl_redirect4ward']['addLogMessage'], $intCounter, $strSource, $strSource));
		$this->redirect(ampersand(str_replace('&key=importLogs', '', $this->Environment->request)), 301);
	}

	private function addLocation($strLoc)
	{
		$arrUrlFragments = parse_url($strLoc);
		$arrSet = array(
			'url' => trim($arrUrlFragments['path'], '/'),
			'host' => str_replace('www.', '', $arrUrlFragments['host'])
		);
		return $this->addSite($arrSet);
	}


	private function addSite($arrSet)
	{

		if(!strlen($arrSet['url']))
			return FALSE;
		if(!in_array($arrSet['host'], $this->arrHosts))
		{
			unset($arrSet['host']);
		}
		
		
		
		$arrSet['tstamp'] = time();
		$objRedirect = $this->Database->prepare("SELECT id FROM tl_redirect4ward WHERE url=? AND host=?")->limit(1)->execute($arrSet['url'], isset($arrSet['host']) ? $arrSet['host'] : '');
		if($objRedirect->numRows == 0)
		{
			$this->Database->prepare("INSERT INTO tl_redirect4ward %s")->set($arrSet)->execute();
			return TRUE;
		}
		return FALSE;
	}

}
?>