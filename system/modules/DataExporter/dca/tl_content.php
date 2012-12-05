<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
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
 * @copyright  Cliff Parnitzky 2012
 * @author     Cliff Parnitzky
 * @package    DataExporter
 * @license    LGPL
 */

/**
 * Add palettes to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['dataExporterForm'] = '{type_legend},type,headline;{export_legend},exportFolder,exporter;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_content']['palettes']['dataExporterList'] = '{type_legend},type,headline;{export_legend},exportFolder,fileExtension,sortBy;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

/**
 * Add fields to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['exportFolder'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_content']['exportFolder'],
	'exclude'   => true,
	'inputType' => 'fileTree',
	'eval'      => array('fieldType'=>'radio', 'mandatory'=>true, 'files'=>false, 'filesOnly'=>false)
);
$GLOBALS['TL_DCA']['tl_content']['fields']['fileExtension'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_content']['fileExtension'],
	'exclude'   => true,
	'inputType' => 'select',
	'options'   => explode(&$GLOBALS['TL_CONFIG']['allowedDownload']),
	'eval'      => array('mandatory'=>true, 'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_content']['fields']['exporter'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_content']['exporter'],
	'exclude'   => true,
	'inputType' => 'select',
	'options'   => &$GLOBALS['TL_DATA_EXPORTER'],
	'reference' => &$GLOBALS['TL_LANG']['DATA_EXPORTER'],
	'eval'      => array('mandatory'=>true)
);




?>