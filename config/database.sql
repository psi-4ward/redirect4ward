-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

-- 
-- Table `tl_module`
-- 

CREATE TABLE `tl_redirect4ward` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `url` varchar(255) NOT NULL default '',
  `host` varchar(255) NOT NULL default '',
  `type` varchar(3) NOT NULL default '',
  `jumpToType` varchar(10) NOT NULL default '',
  `jumpTo` int(10) unsigned NOT NULL default '0',
  `externalUrl` varchar(255) NOT NULL default '',
  `rgxp` char(1) NOT NULL default '',
  `published` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

