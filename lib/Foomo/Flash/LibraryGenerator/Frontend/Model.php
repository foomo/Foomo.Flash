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
class Model
{
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var string
	 */
	public $report;
	/**
	 * @var Foomo\Flash\LibraryGenerator\Config\Preset[]
	 */
	public $presets;
	/**
	 *
	 * @var Foomo\Flash\Vendor\Sources
	 */
	public $sources;
	/**
	 * @var Foomo\Flash\Vendor\Sources\Project[]
	 */
	public $libraryProjects = array();

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	public function __construct()
	{
		$this->sources = \Foomo\Flash\Vendor::getSources();
		foreach ($this->sources->getLibraryProjects(false) as $libraryProject) {
			/* @var $libraryProject Foomo\Flash\Vendor\Sources\Project */
			if (!isset($this->libraryProjects[$libraryProject->group])) $this->libraryProjects[$libraryProject->group] = array();
			$this->libraryProjects[$libraryProject->group][] = $libraryProject;
		}
	}
}