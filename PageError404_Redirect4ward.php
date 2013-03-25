<?php if(!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright 	4ward.media 2012 <http://www.4wardmedia.de>
 * @author 		Christoph Wiechert <wio@psitrax.de>
 * @license    	LGPL
 * @package 	redirect4ward
 * @filesource
 */
 
class PageError404_Redirect4ward extends PageError404
{


	public function __construct()
	{
		parent::__construct();
		$this->redirect4ward();
	}


	function redirect4ward()
	{
		$this->import('Environment');
		$this->import('Database');
		$url = $this->Environment->request;

		// Kill querystring
		if(isset($GLOBALS['TL_CONFIG']['redirect4wardKillQueryStr']) && $GLOBALS['TL_CONFIG']['redirect4wardKillQueryStr'] == true )
		{
			$url = (strpos($url, '?') === false) ? $url : substr($url, 0,strpos($url, '?'));
		}

		// Kill trialing /
		if(substr($url,-1) == '/') $url = substr($url,0,-1);

		// decode url
		$url = urldecode($url);

		$objTarget = $this->Database->prepare('	SELECT jumpTo,jumpToML,type,jumpToType,externalUrl,url,rgxp
												FROM tl_redirect4ward
												WHERE 	published=?
														AND (
																	(rgxp="" AND url=?)
															 	 OR (rgxp="1" AND ? REGEXP url)
															 )
														AND (host=? OR CONCAT("www.",host)=? OR host="")
												ORDER BY url, priority'
											)
						->limit(1)->execute('1',$url,$url,$this->Environment->host,$this->Environment->host);
		

		if($objTarget->numRows > 0)
		{
			if($objTarget->jumpToType == 'Intern')
			{
				// Redirect to internal jumpTo page
				$objJumpTo = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")->limit(1)->execute($objTarget->jumpTo);
				if ($objJumpTo->numRows)
				{
					$type = ($objTarget->type=='301')?'301':'303'; // TL knows only "303: see other", no "307: temporary"

					// set objPage cause we need the rootLanguage there for generateFrontendUrl
					$GLOBALS['objPage'] = $this->getPageDetails($objJumpTo->id);

					$this->redirect($this->generateFrontendUrl($objJumpTo->row()),$type);
				}
			}
			else if($objTarget->jumpToType == 'InternML')
			{
				// Get the settings
				$arrRedirectSettings = deserialize($objTarget->jumpToML);
				$mixJumpTo = '';
				$mixJumpToFallback = '';
                $mixParameters = '';
                $mixParametersFallback = '';
				
				// Search jump to
				foreach ($arrRedirectSettings as $arrSetting)
				{
					// Search Fallback
					if($arrSetting['language'] == 'fallback')
					{
						$mixJumpToFallback = $arrSetting['jumpTo'];
                        $mixParametersFallback = $arrSetting['parameters'];
					}
					
					// Search current language
					if($GLOBALS['TL_LANGUAGE'] == $arrSetting['language'])
					{
						$mixJumpTo = $arrSetting['jumpTo'];
                        $mixParameters = $arrSetting['parameters'];
					}
				}
				
				// No fallback, no language .... return;
				if($mixJumpTo == '' && $mixJumpToFallback == '')
				{
					return;
				}
				
				// Return if we have no jump to
				if($mixJumpTo == '')
				{
					$mixJumpTo = $mixJumpToFallback;
                    $mixParameters = $mixParametersFallback;
				}
				
				// Get ID from inserttag 
				// ToDo: PagePicker is not the right one. 
				$mixJumpTo = str_replace(array('{{', '}}', 'link_url::'), array('', '', ''), $mixJumpTo);

				// Redirect to internal jumpTo page				
				$objJumpTo = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")->limit(1)->execute($mixJumpTo);
				                
				if ($objJumpTo->numRows)
				{
					$type = ($objTarget->type=='301')?'301':'303'; // TL knows only "303: see other", no "307: temporary"

					// set objPage cause we need the rootLanguage there for generateFrontendUrl
					$GLOBALS['objPage'] = $this->getPageDetails($objJumpTo->id);
                    
					$this->redirect($this->generateFrontendUrl($objJumpTo->row(), html_entity_decode($mixParameters)),$type);
				}
			}
			else if($objTarget->jumpToType == 'Extern')
			{
				$targetURL = $objTarget->externalUrl;
				// replace regex-params
				if($objTarget->rgxp == '1' && preg_match("~{$objTarget->url}~i", $url,$erg))
				{
					foreach($erg as $i=>$param)
					{
						$targetURL = str_replace('$'.$i, $param, $targetURL);
					}
				}

				// Redirect to external page
				$type = ($objTarget->type == '301') ? '301' : '303'; // TL knows only "303: see other", no "307: temporary"
                $this->redirect($targetURL,$type);
			}
		}
	}
}