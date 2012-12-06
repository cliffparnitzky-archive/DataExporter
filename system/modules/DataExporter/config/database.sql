-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

-- 
-- Table `tl_content`
-- 

CREATE TABLE `tl_content` (
  `exportFolder` varchar(255) NOT NULL default '',
  `fileExtension` varchar(5) NOT NULL default '',
  `exporter` varchar(255) NOT NULL default '',
  `exporterFormTemplate` varchar(255) NOT NULL default '',
  `exporterListTemplate` varchar(255) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;