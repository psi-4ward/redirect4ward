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

class Redirect4ward extends Controller
{
	
	function getPageIdFromURL($urlfragments)
	{
		$this->import('Database');
		$url = $this->Environment->request;
		
		
		// Kill querystring
		if(isset($GLOBALS['TL_CONFIG']['redirect4wardKillQueryStr']) && $GLOBALS['TL_CONFIG']['redirect4wardKillQueryStr'] == true )
		{
			$url = (strpos($url, '?') === false) ? $url : substr($url, 0,strpos($url, '?'));
		}
		
		// Kill trialing /
		if(substr($url,-1) == '/') $url = substr($url,0,-1);
		
		$objTarget = $this->Database->prepare('SELECT jumpTo,type,jumpToType,externalUrl FROM tl_redirect4ward WHERE published=? AND url=? AND (host=? OR host="")')
						->limit(1)->execute('1',$url,$this->Environment->host);

		if($objTarget->numRows > 0)
		{
			if($objTarget->jumpToType == 'Intern')
			{
				// Redirect to internal jumpTo page
				$objJumpTo = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")->limit(1)->execute($objTarget->jumpTo);
				if ($objJumpTo->numRows)
				{
					$type = ($objTarget->type=='301')?'301':'303'; // TL knows only "303: see other", no "307: temporary"
					$this->redirect($this->generateFrontendUrl($objJumpTo->fetchAssoc()),$type);
				}
			}
			else if($objTarget->jumpToType == 'Extern')
			{
				// Redirect to external page
				$type = ($objTarget->type=='301')?'301':'303'; // TL knows only "303: see other", no "307: temporary"
				$this->redirect($objTarget->externalUrl,$type);
			}
		}
		
		
		return $urlfragments;
	}	
	
} 

?>