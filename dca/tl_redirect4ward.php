<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * @copyright 	4ward.media 2012 <http://www.4wardmedia.de>
 * @author 		Christoph Wiechert <wio@psitrax.de>
 * @license    	LGPL
 * @package 	redirect4ward
 * @filesource
 */


$GLOBALS['TL_DCA']['tl_redirect4ward'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => false,
		'onsubmit_callback'           => array
		(
			array('tl_redirect4ward', 'updateHtaccess')
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('priority', 'url'),
			'flag'                    => 11,
			'panelLayout'             => 'filter;search,limit',
		),
		'label' => array
		(
			'fields'                  => array('url', 'type','host'),
			'label_callback'		  => array('tl_redirect4ward','label'),
			'format'                  => '%s'
		),
		'global_operations' => array
		(
      'importSitemap' => array(
        'label'								=> &$GLOBALS['TL_LANG']['tl_redirect4ward']['importSitemap'],
        'href' 								=> 'key=importSitemap',
				'class'               => 'header_new',
        'attributes' 					=> 'onclick="Backend.getScrollOffset();"'
    	),
      'importLogs' => array(
        'label' 							=> &$GLOBALS['TL_LANG']['tl_redirect4ward']['importLogs'],
        'href' 								=> 'key=importLogs',
				'class'               => 'header_new',
      	'attributes' 					=> 'onclick="Backend.getScrollOffset();"'
  		),
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_redirect4ward']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_redirect4ward']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_redirect4ward']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_redirect4ward']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('jumpToType'),
		'default'                     => '{type_legend},jumpToType;{target_legend},url,host,rgxp,jumpTo;{expert_legend},type,priority;{publish_legend},published',
		'Intern'           			  => '{type_legend},jumpToType;{target_legend},url,host,rgxp,jumpTo;{expert_legend},type,priority;{publish_legend},published',
		'InternML'           		  => '{type_legend},jumpToType;{target_legend},url,host,rgxp,jumpToML;{expert_legend},type,priority;{publish_legend},published',
		'Extern'           			  => '{type_legend},jumpToType;{target_legend},url,host,rgxp,externalUrl;{expert_legend},type,priority;{publish_legend},published'
	),

	// Fields
	'fields' => array
	(
		'jumpToType' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpToType'],
			'exclude'                 => true,
			'inputType'               => 'radio',
			'filter'                  => true,
			'default'				  => 'Intern',
			'options'				  => array(
											'Intern' 	=> &$GLOBALS['TL_LANG']['tl_content']['tl_redirect4ward']['tl_redirect4wardTypes']['intern'],
											'InternML' 	=> &$GLOBALS['TL_LANG']['tl_content']['tl_redirect4ward']['tl_redirect4wardTypes']['intern_ml'],
											'Extern'	=> &$GLOBALS['TL_LANG']['tl_content']['tl_redirect4ward']['tl_redirect4wardTypes']['extern']
										),
			'eval'                    => array('mandatory'=>true,'submitOnChange'=>true)
		),
		'url' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_redirect4ward']['url'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'long','decodeEntities'=>true)
		),
		'host' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_redirect4ward']['host'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'default'				  => '-',
			'options_callback'		  => array('tl_redirect4ward','getHosts'),
			'eval'                    => array('maxlength'=>255,'tl_class'=>'w50')
		),
		'rgxp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_redirect4ward']['rgxp'],
			'exclude'                 => true,
			'default'				  => '0',
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50 m12')
		),
		'jumpTo' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpTo'],
			'exclude'                 => true,
			'inputType'               => 'pageTree',
			'eval'                    => array('fieldType'=>'radio','mandatory'=>true,'tl_class'=>'clr')
		),
		'jumpToML' => array(
			'label'				      => &$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpTo'],
			'inputType'				  => 'multiColumnWizard',
			'load_callback'			  => array(array('tl_redirect4ward', 'getLanguageFields')),
			'eval' => array(
				'buttons'	=> array(
					'copy'			  => false,
					'delete'		  => false,
					'up'			  => false,
					'down'			  => false
				),
				'style'						 => 'width:100%;',
				'tl_class'					 =>'clr',
				'columnFields'				 => array(
					'language'				 => array(
						'label'				 => &$GLOBALS['TL_LANG']['tl_redirect4ward']['language'],						
						'inputType'			 => 'justtextoption',
						'options_callback'	 => array('tl_redirect4ward', 'getActivePageLanguages'),
						'eval'				 => array(
							'hideHead'		 => false,
							'hideBody'		 => false,
						)
					),
					'jumpTo'				 => array(
						'label'				 => &$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpTo'],						
						'inputType'			 => 'text',
						'eval'				 => array(
							'mandatory'		 => true,
							'rgxp'			 => 'url',
							'decodeEntities' => true,
							'maxlength'		 => 255,
							'hideHead'		 => false,
							'hideBody'		 => false,
                            'style'          => 'width:150px;',
						),
						'wizard'			 => array(
							array('tl_redirect4ward', 'pagePicker')
						)
					),
					'parameters'		     => array(
						'label'				 => &$GLOBALS['TL_LANG']['tl_redirect4ward']['parameters'],						
						'inputType'			 => 'text',
						'eval'				 => array(
                            'trailingSlash'  => false,
							'mandatory'		 => false,
							'maxlength'		 => 255,
							'hideHead'		 => false,
							'hideBody'		 => false,
                            'style'          => 'width:360px;',
						)						
					),                    
				),				
			)
		),
		'externalUrl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_redirect4ward']['externalUrl'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'clr long','decodeEntities'=>true)
		),
		'type' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_redirect4ward']['type'],
			'default'                 => '301',
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'radio',
			'reference'				  => &$GLOBALS['TL_LANG']['tl_redirect4ward']['typeOptions'],
			'options'        		  => array('301', '307'),
			'eval'                    => array('tl_class'=>'w50','mandatory'=>true)
		),
		'priority' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_redirect4ward']['priority'],
			'default'                 => 10,
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'maxlength'=>10,'tl_class'=>'w50')
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_redirect4ward']['published'],
			'exclude'                 => true,
			'default'				  => '1',
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50')
		)
	)
);

class tl_redirect4ward extends Controller
{
	/**
	 * @var Htaccess
	 */
	protected $Htaccess;
	
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function updateHtaccess()
	{
		if (isset($GLOBALS['TL_CONFIG']['redirect4ward_use_htaccess']) &&
			$GLOBALS['TL_CONFIG']['redirect4ward_use_htaccess'] &&
			in_array('htaccess', $this->Config->getActiveModules())) {
			$this->import('Htaccess');
			$this->Htaccess->update();
		}
	}
	
	public function label($row, $label, DataContainer $dc=null)
	{
		$strTestUrl = $this->Environment->ssl ? 'https://' : 'http://';
		if ($row['host']) {
			$strTestUrl .= $row['host'];
		}
		else {
			$strTestUrl .= $this->Environment->host;
		}
		$strTestUrl .= '/' . $row['url'];

		$strTestIcon = '<a href="' . $strTestUrl . '" target="_blank">' . $this->generateImage('system/themes/default/images/root.gif', '') . '</a>';

		$strUrl = '';
		if ($row['host']) {
			$strUrl .= ($this->Environment->ssl ? 'https://' : 'http://') . $row['host'] . '/';
		}
		$strUrl .= $row['url'];

		$strTarget = '';
		switch ($row['jumpToType'])
		{
			// ...for internal redirects
			case 'Intern':
				$objPage = $this->Database
					->prepare('SELECT * FROM tl_page WHERE id=?')
					->execute($row['jumpTo']);
				if (!$objPage->next()) {
					$strTarget = 'unknown page!';
				}
				else {
					$strTarget = $this->generateFrontendUrl($objPage->row());
				}
				break;
				
			case 'InternML':
				$objPage = $this->Database
					->prepare('SELECT * FROM tl_redirect4ward WHERE id=?')
					->execute($row['id']);
				
				$arrValues = deserialize($objPage->jumpToML);
				
				if (count($arrValues) == 0) {
					$strTarget = 'unknown page!';
				}
				else {
					$strReturn = '<ul>';
					 foreach ($arrValues as $value)
					 {
						$strReturn .= '<li>' . $value['language'] . ' : ' . $this->replaceInsertTags($value['jumpTo']) . $value['parameters'] . '</li>';
					 }
					 $strReturn .= '</ul>';
					
					$strTarget = $strReturn;
				}
				break;	

			// ...for external redirects
			case 'Extern':
				$strTarget = $row['externalUrl'];
				break;

			// ...or continue with next
			default:
				$strTarget = 'invalid target!';
		}

		$rgxp = (strlen($row['rgxp'])) ? '; REGEX' : '';
		return sprintf('%s %s &rarr; %s <span style="color:#b3b3b3; padding-left:3px;">[%s%s]</span>',
			$strTestIcon,
			$strUrl,
			$strTarget,
			$GLOBALS['TL_LANG']['tl_redirect4ward']['typeOptions'][$row['type']],
			$rgxp);
	}
	
	public function getHosts()
	{
		$erg = $this->Database->execute('SELECT DISTINCT(dns) FROM tl_page WHERE type="root"');
		$arr = array(''=>$GLOBALS['TL_LANG']['tl_redirect4ward']['everyHost']);
		while($erg->next())
		{
			if(!strlen($erg->dns)) continue;
			$dns = preg_replace('/^www\./i', '', $erg->dns);
			$arr[$dns] = $dns;
		}
		return $arr;
	}
	
	/**
	 * Load all active laguages
	 * 
	 * @return array
	 */
	public function getActivePageLanguages()
	{
		$arrReturn = array();

		$arrLanguages = $this->getLanguages();

		$arrRootPages = $this->Database
				->query('SELECT language FROM tl_page WHERE type="root" ')
				->fetchAllAssoc();
		
		$arrReturn['fallback'] = 'Fallback';

		foreach ($arrRootPages as $value)
		{
			if (array_key_exists($value['language'], $arrLanguages))
			{
				$arrReturn[$value['language']] = $arrLanguages[$value['language']];
			}
			else
			{
				$arrReturn[$value['language']] = $value['language'];
			}
		}

		return $arrReturn;
	}
	
	/**
	 * Compare current page language against the stored once.
	 * 
	 * @param array $varValue
	 * @return array
	 */
	public function getLanguageFields($varValue)
	{
        $varValue	 = deserialize($varValue, true); 
		$newValues	 = array();
		$arrValues = array();
		
		foreach ($varValue as $value)
        {
            $arrValues[$value['language']] = array(
                'jumpTo'     => $value['jumpTo'],
                'parameters' => $value['parameters']
            );
        }

		$arrRootPages = $this->Database
				->query('SELECT language FROM tl_page WHERE type="root"')
				->fetchAllAssoc();
		
		$newValues[] = array(
            'language'   => 'fallback',
            'jumpTo'     => $arrValues['fallback']['jumpTo'],
            'parameters' => $arrValues['fallback']['parameters']
        );

        foreach ($arrRootPages as $value)
        {
            $newValues[] = array(
                'language'   => $value['language'],
                'jumpTo'     => $arrValues[$value['language']]['jumpTo'],
                'parameters' => $arrValues[$value['language']]['parameters'],
            );
        }
        
        return serialize($newValues);
	}
	
	/**
	 * Return the link picker wizard
	 * @param DataContainer
	 * @return string
	 */
	public function pagePicker(DataContainer $dc)
	{
		return ' ' . $this->generateImage('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer" onclick="Backend.pickPage(\'ctrl_' . $dc->inputName . '\')"');
	}
	
}
