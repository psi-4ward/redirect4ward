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
		'enableVersioning'            => false
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('url'),
			'flag'                    => 1,
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
		'default'                     => '{type_legend},jumpToType;{target_legend},url,host,rgxp,jumpTo;{expert_legend},type,published',
		'Intern'           			  => '{type_legend},jumpToType;{target_legend},url,host,rgxp,jumpTo;{expert_legend},type,published',
		'Extern'           			  => '{type_legend},jumpToType;{target_legend},url,host,rgxp,externalUrl;{expert_legend},type,published'
	),

	// Fields
	'fields' => array
	(
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
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_redirect4ward']['published'],
			'exclude'                 => true,
			'default'				  => '1',
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50')
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
			'eval'                    => array('fieldType'=>'radio','mandatory'=>true)
		),
		'jumpToType' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_redirect4ward']['jumpToType'],
			'exclude'                 => true,
			'inputType'               => 'radio',
			'filter'                  => true,
			'default'				  => 'Intern',
			'options'				  => array(
											'Intern' 	=> &$GLOBALS['TL_LANG']['tl_content']['tl_redirect4ward']['tl_redirect4wardTypes']['intern'],
											'Extern'	=> &$GLOBALS['TL_LANG']['tl_content']['tl_redirect4ward']['tl_redirect4wardTypes']['extern']
										),
			'eval'                    => array('mandatory'=>true,'submitOnChange'=>true)
		),
		'externalUrl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_redirect4ward']['externalUrl'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'long','decodeEntities'=>true)
		),		
	)
);

class tl_redirect4ward extends Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
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
	
}
?>
