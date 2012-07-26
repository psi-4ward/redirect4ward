<?php
if(!defined('TL_ROOT'))
	die('You cannot access this file directly!');

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

	public function __construct()
	{
		parent::__construct();
		$this->Template = new BackendTemplate('be_import_sitemap');
	}

	/**
	 * Import a sitemap
	 */
	public function importSitemap()
	{
		$blnError = false;
		$this->loadLanguageFile('tl_redirect4ward');
		$this->blnSave = true;

		$this->Template->sitemap_source = $this->getSitemapWidget();
		$this->Template->sitemap_source_label = $GLOBALS['TL_LANG']['tl_redirect4ward']['sitemap_source_label'][0];

		$this->Template->hrefBack = ampersand(str_replace('&key=importSitemap', '', $this->Environment->request));
		$this->Template->goBack = $GLOBALS['TL_LANG']['MSC']['goBack'];
		$this->Template->headline = $GLOBALS['TL_LANG']['tl_redirect4ward']['sitemap_headline'][0];
		$this->Template->request = ampersand($this->Environment->request, ENCODE_AMPERSANDS);
		$this->Template->submit = specialchars($GLOBALS['TL_LANG']['MSC']['continue']);

		if($this->Input->post('FORM_SUBMIT') == 'tl_import_sitemap' && $this->blnSave)
		{
			$this->import('tl_redirect4ward');
			$this->import('Request');

			$this->arrHosts = $this->tl_redirect4ward->getHosts();
			$strSource = $this->Template->sitemap_source->value;
			if(!strlen($strSource))
			{
				$this->setStatus(sprintf($GLOBALS['TL_LANG']['tl_redirect4ward']['addSitemapErrorMessage'], $strSource, $strSource), 'Redirect importSitemap()', true);
				$blnError = true;

			}
			$intCounter = 0;

			$objReq = new Request();
			$objReq->send($strSource);

			if(!$objReq->hasError())
			{
				$objXml = simplexml_load_string($objReq->response);
				if(!$objXml)
				{
					$this->setStatus(sprintf($GLOBALS['TL_LANG']['tl_redirect4ward']['addSitemapErrorMessage'], $strSource, $strSource), 'Redirect importSitemap()', true);
					$blnError = true;
				}
				foreach($objXml as $objUrl)
				{
					if($this->addLocation($objUrl->loc))
						$intCounter++;
				}
			}
			else
			{
				$this->setStatus(sprintf($GLOBALS['TL_LANG']['tl_redirect4ward']['addSitemapErrorMessage'], $strSource, $strSource), 'Redirect importSitemap()', true);
				$blnError = true;
			}
			if(!$blnError)
				$this->setStatus(sprintf($GLOBALS['TL_LANG']['tl_redirect4ward']['addSitemapMessage'], $intCounter, $strSource, $strSource), 'Redirect importSitemap()');
		}

		return $this->Template->parse();
	}

	/**
	 * Import from logs
	 */
	public function importLogs()
	{
		$this->import('tl_redirect4ward');

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
		$this->setStatus(sprintf($GLOBALS['TL_LANG']['tl_redirect4ward']['addLogMessage'], $intCounter, $strSource, $strSource), 'Redirect importLogs()');
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

	private function setStatus($strStatus, $strFunction, $blnError = false)
	{
		if(version_compare(VERSION, '2.11') >= 0)
		{
			// addInfoMessage and addErrorMessage are available
			if($blnError)
			{
				$this->addErrorMessage($strStatus);
			}
			else
			{
				$this->addInfoMessage($strStatus);
			}
		}

		if($blnError)
		{
			$this->log(strip_tags($strStatus), $strFunction, TL_ERROR);
			$this->Template->statusClass = 'tl_error';
		}
		else
		{
			$this->log(strip_tags($strStatus), $strFunction, TL_INFO);
			$this->Template->statusClass = 'tl_info';
		}
		$this->Template->hasStatus = true;
		$this->Template->status = $strStatus;

	}

	private function getSitemapWidget($value = null)
	{
		$widget = new TextField();

		$widget->id = 'sitemap_source';
		$widget->name = 'sitemap_source';
		$widget->mandatory = true;
		$widget->strTable = 'tl_redirect4ward';
		$widget->strField = 'sitemap_source';
		$widget->value = $value;

		$widget->label = $GLOBALS['TL_LANG']['tl_redirect4ward']['sitemap_source'][0];

		if($GLOBALS['TL_CONFIG']['showHelp'] && strlen($GLOBALS['TL_LANG']['tl_redirect4ward']['sitemap_source'][1]))
		{
			$widget->help = $GLOBALS['TL_LANG']['tl_redirect4ward']['sitemap_source'][1];
		}

		// Valiate input
		if($this->Input->post('FORM_SUBMIT') == 'tl_import_sitemap')
		{
			$widget->validate();
			if($widget->hasErrors())
			{
				$this->blnSave = false;
			}
		}

		return $widget;
	}

}
?>