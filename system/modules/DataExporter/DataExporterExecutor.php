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
		if (strlen($this->Input->post("FORM_SUBMIT")) > 0) {
			$ceId = $this->Input->post("FORM_SUBMIT");
			
			$objConfig = $this->Database->prepare("SELECT * FROM tl_content WHERE id = ?")
										->limit(1)
										->execute($ceId);
			
			$exporter = $objConfig->exporter;
			if ($this->classFileExists($exporter)) {
				$dataExporter = new $exporter;
				if ($dataExporter instanceof AbstractDataExporter) {
					$file = $dataExporter->createExportFile($objConfig);
					// Send the file to the browser
					if ($file != '') {
						$this->sendFileToBrowser($file);
					}
				}
			}
		}
		echo "<html><head></head><body><br><b>Export error</b>: somthing went wrong, maybe the export executer was not called through the contao framework, or the defined exporter class does not exists, or the defined exporter is not an instance of <i>AbstractDataExporter</i></body></html>";
	}
}

/**
 * Instantiate executor
 */
$dataExporterExecutor = new DataExporterExecutor();
$dataExporterExecutor->run();

?>