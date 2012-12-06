<?php

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
 * Initialize the system
 */
require_once('../../initialize.php');

/**
 * Class DataExporterExecutor
 *
 * The executor of an export.
 * @copyright  Cliff Parnitzky 2012
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class DataExporterExecutor extends Controller {
	public function __construct() {
		parent::__construct();
		$this->import('Input');
		$this->import('Database');
	}
	
	/**
	 * Run controller
	 */
	public function run()
	{
		$errorMsg = 'the export executer was not called through the contao framework';
		
		$allowedDownload = trimsplit(',', strtolower($GLOBALS['TL_CONFIG']['allowedDownload']));

		if (strlen($this->Input->post("FORM_SUBMIT")) > 0) {
			$ceId = $this->Input->post("FORM_SUBMIT");
			
			$objConfig = $this->Database->prepare("SELECT * FROM tl_content WHERE id = ?")
										->limit(1)
										->execute($ceId);
			
			$exporter = $objConfig->exporter;
			$errorMsg = 'the defined exporter class <i>' . $exporter . '</i> does not exists';
			if ($this->classFileExists($exporter)) {
				$errorMsg = 'the defined exporter is not an instance of <i>AbstractDataExporter</i>';
				$dataExporter = new $exporter;
				if ($dataExporter instanceof AbstractDataExporter) {
					$errorMsg = 'an error occured while exporting';
					$file = $dataExporter->createExportFile($objConfig);
					// Send the file to the browser
					$errorMsg = 'the export file does not exists';
					if (is_file(TL_ROOT . '/' . $file)) {
						$errorMsg = 'its not allowed to download the export file';
						$objFile = new File($file);
						if (in_array($objFile->extension, $allowedDownload)) {
							$this->sendFileToBrowser($file);
							return;
						}
					}
				}
			}
		}
		echo "<html><head></head><body><br><b>Export error</b>: something went wrong, " . $errorMsg . ".</body></html>";
	}
}

/**
 * Instantiate executor
 */
$dataExporterExecutor = new DataExporterExecutor();
$dataExporterExecutor->run();

?>