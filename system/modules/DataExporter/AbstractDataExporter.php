<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

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
 * @copyright  Cliff Parnitzky 2012
 * @author     Cliff Parnitzky
 * @package    DataExporter
 * @license    LGPL
 */

/**
 * Class AbstractDataExporter
 *
 * The abstract definition of an exporter.
 * @copyright  Cliff Parnitzky 2012
 * @author     Cliff Parnitzky
 * @package    Controller
 */
abstract class AbstractDataExporter extends System {
	/**
	 * Create the export file.
	 * 
	 * @param objConfig The configuration from database (equivalent to the configuratrion of the content element).
	 *
	 * @return The path to the new file.
	 */
	public abstract function createExportFile($objConfig);
	
	/**
	 * Creates a new file in the given export folder, with the given name and extension
	 *
	 * @param objConfig The configuration from database (equivalent to the configuratrion of the content element).
	 * @param fileName The file name to be used.
	 * @param fileExtension The file extension to be used.
	 *
	 * @return The new file.
	 */
	protected function createFile($objConfig, $fileName, $fileExtension, $createEmpty = true) {
		$filePath = $objConfig->exportFolder . '/' . $fileName . '.' . $fileExtension;
		$file = new File($filePath);
		
		if ($createEmpty) {
			$file->truncate();
		}
		
		return $file;
	}
}

?>