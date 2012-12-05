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
 * Class ContentDataExporterList
 *
 * Front end content element for listing the export files.
 * @copyright  Cliff Parnitzky 2012
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class ContentDataExporterList extends ContentElement {

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_data_exporter_list';
	
	/**
	 * Return if there are no files
	 * @return string
	 */
	public function generate()
	{
		$file = $this->Input->get('file', true);

		// Send the file to the browser
		if ($file != '')
		{
			$this->sendFileToBrowser($file);
		}

		return parent::generate();
	}

	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		$files = array();
		$auxDate = array();

		if (isset($files[$this->exportFolder]) || !file_exists(TL_ROOT . '/' . $this->exportFolder))
		{
			continue;
		}

		$subfiles = scan(TL_ROOT . '/' . $this->exportFolder);
		$this->parseMetaFile($this->exportFolder);

		// Folders
		foreach ($subfiles as $subfile)
		{
			if (is_dir(TL_ROOT . '/' . $this->exportFolder . '/' . $subfile))
			{
				continue;
			}

			$objFile = new File($this->exportFolder . '/' . $subfile);

			if ($objFile->extension == $this->fileExtension && !preg_match('/^meta(_[a-z]{2})?\.txt$/', basename($subfile)))
			{
				$arrMeta = $this->arrMeta[$objFile->basename];

				if ($arrMeta[0] == '')
				{
					$arrMeta[0] = specialchars($objFile->basename);
				}

				$files[$this->exportFolder . '/' . $subfile] = array
				(
					'link' => $arrMeta[0],
					'title' => $arrMeta[0],
					'href' => $this->Environment->request . (($GLOBALS['TL_CONFIG']['disableAlias'] || strpos($this->Environment->request, '?') !== false) ? '&amp;' : '?') . 'file=' . $this->urlEncode($this->exportFolder . '/' . $subfile),
					'caption' => $arrMeta[2],
					'filesize' => $this->getReadableSize($objFile->filesize, 1),
					'icon' => 'system/modules/DataExporter/html/csv.png',
					'mime' => $objFile->mime,
					'meta' => $arrMeta,
					'extension' => $objFile->extension,
					'path' => $objFile->dirname
				);

				$auxDate[] = $objFile->mtime;
			}
		}

		// Sort array
		switch ($this->sortBy)
		{
			default:
			case 'name_asc':
				uksort($files, 'basename_natcasecmp');
				break;

			case 'name_desc':
				uksort($files, 'basename_natcasercmp');
				break;

			case 'date_asc':
				array_multisort($files, SORT_NUMERIC, $auxDate, SORT_ASC);
				break;

			case 'date_desc':
				array_multisort($files, SORT_NUMERIC, $auxDate, SORT_DESC);
				break;

			case 'meta':
				$arrFiles = array();
				foreach ($this->arrAux as $k)
				{
					if (strlen($k))
					{
						$arrFiles[] = $files[$k];
					}
				}
				$files = $arrFiles;
				break;
		}

		$this->Template->files = array_values($files);
	}
}

?>