<?php

/*
 * This file is part of the foomo Opensource Framework.
 *
 * The foomo Opensource Framework is free software: you can redistribute it
 * and/or modify it under the terms of the GNU Lesser General Public License as
 * published  by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * The foomo Opensource Framework is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with
 * the foomo Opensource Framework. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Foomo\Flash\LibraryGenerator\Frontend;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Controller
{
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * model
	 *
	 * @var Foomo\Flash\LibraryGenerator\Frontend\Model
	 */
	public $model;

	//---------------------------------------------------------------------------------------------
	// ~ Action methods
	//---------------------------------------------------------------------------------------------

	/**
	 * This method is executed by default
	 */
	public function actionDefault()
	{
		$this->model->presets = \Foomo\Flash\Module::getLibraryGeneratorConfig()->getPresets();
	}

	public function actionGetLibrary($projectLibraryId, $sdkId)
	{
		$filename = \Foomo\Flash\LibraryGenerator::compile(array($projectLibraryId), $sdkId, $this->model->report);
		if (file_exists($filename)) {
			\Foomo\MVC::abort();
			$libraryProject = $this->model->sources->getLibraryProject($projectLibraryId);
			\Foomo\Utils::streamFile($filename, $libraryProject->getLibraryName() . '.swc', 'application/octet-stream', true);
			exit;
		}
	}

	/**
	 * @param string $name
	 * @param string[] $projectLibraryIds
	 */
	public function actionGetCustomLibrary($sdkId)
	{
		$name = $_POST['name'];
		$projectLibraryIds = $_POST['projectLibraryIds'];
		if (is_null($projectLibraryIds) || empty($projectLibraryIds)) \Foomo\MVC::redirect('default');
		$filename = \Foomo\Flash\LibraryGenerator::compile($projectLibraryIds, $sdkId, $this->model->report);
		if (file_exists($filename)) {
			\Foomo\MVC::abort();
			\Foomo\Utils::streamFile($filename, $name . '.swc', 'application/octet-stream', true);
			exit;
		}
	}

	/**
	 * Renders an ant file and pumps it out
	 */
	public function actionGetAntBuildFile($sdkId)
	{
		$name = (isset($_POST['name'])) ?  $_POST['name'] : 'Foomo';
		$projectLibraryIds = (isset($_POST['projectLibraryIds'])) ? $_POST['projectLibraryIds'] : array();
		$filename = \Foomo\Flash\LibraryGenerator::generateAntBuildFile(
				$name,
				$projectLibraryIds,
				$this->model->libraryProjects,
				$sdkId,
				$this->model->sources
		);
		if ($filename) {
			\Foomo\MVC::abort();
			\Foomo\Utils::streamFile($filename, $_SERVER['HTTP_HOST'] .'-LibraryUpdater.xml', 'text/xml', true);
			exit;
		}
	}
}
