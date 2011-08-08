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

namespace Foomo\Flash\Vendor;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Sources
{
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var string[]
	 */
	private $pathnames;
	/**
	 * @var Foomo\Flash\Vendor\Sources\Project[]
	 */
	private $libraryProjects = array();
	/**
	 * @var Foomo\Flash\Vendor\Sources\Project[]
	 */
	private $implementationProjects = array();
	/**
	 * @var Foomo\Flash\Vendor\Sources\Application[]
	 */
	private $implementationProjectApplications = array();
	/**
	 * @var Foomo\Flash\Vendor\Sources\Library[]
	 */
	private $libraries;

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string[] $pathnames directories to scan for projects
	 * @param boolean $update update the project list
	 */
	public function __construct($pathnames, $update=true)
	{
		$this->pathnames = $pathnames;
		if ($update) $this->updateProjects();
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public function updateProjects()
	{
		$htis->libraryProjects = array();
		$htis->implementationProjects = array();
		$htis->implementationProjectApplications = array();
		$this->scan();
	}

	/**
	 * @param string $libraryProjectId
	 * @return Foomo\Flash\Vendor\Sources\Project
	 */
	public function getLibraryProject($libraryProjectId)
	{
		if(isset($this->libraryProjects[$libraryProjectId])) {
			return $this->libraryProjects[$libraryProjectId];
		} else {
			trigger_error('unknown libraryproject' . $libraryProjectId . ' not found in: ' . implode(', ', array_keys($this->libraryProjects)));
		}
	}

	/**
	 * @param bool $exclude
	 * @return Foomo\Flash\Vendor\Sources\Project[]
	 */
	public function getLibraryProjects($exclude=true)
	{
		$data = array();
		foreach ($this->libraryProjects as $projectId => $project) {
			if ($exclude && $project->exclude) continue;
			$data[$projectId] = $project;
		}
		return $data;
	}

	/**
	 * @param string $libraryProjectId
	 * @param string $implementationProjectId
	 * @return Foomo\Flash\Vendor\Sources\Project
	 */
	public function getImplementationProject($libraryProjectId, $implementationProjectId)
	{
		return $this->implementationProjects[$libraryProjectId][$implementationProjectId];
	}

	/**
	 * @param string $libraryProjectId
	 * @param bool $exclude
	 * @return Foomo\Flash\Vendor\Sources\Project[]
	 */
	public function getImplementationProjects($libraryProjectId, $exclude=true)
	{
		$data = array();
		foreach ($this->implementationProjects[$libraryProjectId] as $projectId => $project) {
			if ($exclude && $project->exclude) continue;
			$data[$projectId] = $project;
		}
		return $data;
	}

	/**
	 * @param string $implementationProjectId
	 * @param string $implementationProjectApplicationId
	 * @return Foomo\Flash\Vendor\Sources\Application
	 */
	public function getImplementationProjectApplication($implementationProjectId, $implementationProjectApplicationId)
	{
		return $this->applications[$implementationProjectId][$implementationProjectApplicationId];
	}

	/**
	 * @param string $implementationProjectId
	 * @return Foomo\Flash\Vendor\Sources\Application[]
	 */
	public function getImplementationProjectApplications($implementationProjectId)
	{
		$data = array();
		foreach ($this->applications[$implementationProjectId] as $applicationId => $application) {
			$data[$applicationId] = $application;
		}
		return $data;
	}

	/**
	 * @return Foomo\Flash\Vendor\Sources\Library
	 */
	public function getLibrary($projectId)
	{
		return (isset($this->libraries[$projectId])) ? $this->libraries[$projectId] : null;
	}

	/**
	 * @return Foomo\Flash\Vendor\Sources\Library []
	 */
	public function getLibraries()
	{
		return $this->libraries;
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Scans the vendor folder
	 */
	private function scan()
	{
		foreach ($this->pathnames as $pathname) {
			foreach (\scandir($pathname) as $dir) {
				$dirname = $pathname . '/' . $dir;
				if (!\is_dir($dirname)) continue;
				if (\substr($dir, 0, 1) == '.') continue;
				$project = $this->readProjectConfig($dirname);
				if (!$project) continue;
				$library = $this->readLibraryConfig($project);
			}
		}
	}

	/**
	 * @return Foomo\Flash\Vendor\Sources\Project
	 */
	private function readProjectConfig($pathname)
	{
		# get config files
		$projectXML = $this->getConfigXML($pathname, 'project', true);
		if (!$projectXML) return false;
		$project = Sources\Project::fromXML($projectXML, $pathname);

		switch ($project->type) {
			case Sources\Project::TYPE_LIBRARY_PROJECT:
				# validate id
				if (isset($this->libraries[$project->id])) throw new \Exception($project->id . ' already exists for "' . $project->name . '"!');
				# create object
				$this->libraryProjects[$project->id] = $project;
				break;
			case Sources\Project::TYPE_IMPLEMENTATION_PROJECT:
				# create package
				if (!isset($this->projects[$project->getLastDependencyId()])) $this->projects[$project->getLastDependencyId()] = array();
				# validate id
				if (isset($this->projects[$project->getLastDependencyId()][$project->id])) throw new \Exception($project->id . ' already exists!');
				# create object
				$this->implementationProjects[$project->getLastDependencyId()][$project->id] = $project;
				# get applications
				foreach ($project->applications as $application) {
					# create package
					if (!isset($this->applications[$project->id])) $this->applications[$project->id] = array();
					# validate id
					if (isset($this->applications[$project->id][$application->id])) throw new \Exception($application->id . ' already exists!');
					# create object
					$this->applications[$project->id][$application->id] = $application;
				}
				break;
			default:
				throw new \Exception('Unknown type "' . $project->type . '"');
				break;
		}

		return $project;
	}

	/**
	 *
	 * @param Foomo\Flash\Vendor\Sources\Project $project
	 * @return Foomo\Flash\Vendor\Sources\Library
	 */
	private function readLibraryConfig($project)
	{
		# get config files
		$libraryXML = $this->getConfigXML($project->pathname, 'library');
		if (!$libraryXML) return false;
		$library = Sources\Library::fromXML($project->id, $libraryXML, $project->pathname);
		$this->libraries[$project->id] = $library;
		return $library;
	}

	/**
	 * @param string $pathname
	 * @return SimpleXMLElement
	 */
	private function getConfigXML($pathname, $configName, $notice=false)
	{
		$xml = $pathname . '/resources/configs/' . $configName . '.xml';
		if ((!\file_exists($xml))) {
			if ($notice) trigger_error('Vendor  ' . $pathname . ' does not contain a /resources/configs/project.xml file!' . $xml);
			return false;
		} else {
			return simplexml_load_file($xml);
		}
	}
}