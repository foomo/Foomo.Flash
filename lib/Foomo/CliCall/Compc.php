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

namespace Foomo\CliCall;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Compc extends \Foomo\CliCall
{
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * Path to the flexsdk
	 *
	 * @var string
	 */
	public $flexsdk;
	/**
	 * @var string[]
	 */
	public $sourcePaths = array();
	/**
	 * @var string[]
	 */
	public $externalLibraryPaths = array();
	/**
	 * @var string[]
	 */
	public $includeSources = array();
	/**
	 * @var string[]
	 */
	public $includeClasses = array();

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $flexsdk
	 * @param string[] $sourcePaths
	 * @param string[] $externalLibraryPaths
	 * @param string[] $includeSources
	 * @param string[] $includeClasses
	 */
	public function __construct($flexsdk, $sourcePaths=array(), $externalLibraryPaths=array(), $includeSources=array(), $includeClasses=array())
	{
		$this->flexsdk = $flexsdk;
		$this->addSourcePaths($sourcePaths);
		$this->addExternalLibraryPaths($externalLibraryPaths);
		$this->addIncludeSources($includeSources);
		$this->addIncludeClasses($includeClasses);
		parent::__construct($this->flexsdk . '/bin/compc');
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string[] $sourcePaths
	 * @return Foomo\CliCall\Compc
	 */
	public function addSourcePaths(array $sourcePaths)
	{
		$this->sourcePaths = array_unique(array_merge($this->sourcePaths, $sourcePaths));
		return $this;
	}

	/**
	 * @param string[] $externalLibraryPaths
	 * @return Foomo\CliCall\Compc
	 */
	public function addExternalLibraryPaths(array $externalLibraryPaths)
	{
		$this->externalLibraryPaths = array_unique(array_merge($this->externalLibraryPaths, $externalLibraryPaths));
		return $this;
	}

	/**
	 * @param string[] $includeSources
	 * @return Foomo\CliCall\Compc
	 */
	public function addIncludeSources(array $includeSources)
	{
		$this->includeSources = array_unique(array_merge($this->includeSources, $includeSources));
		return $this;
	}

	/**
	 * @param string[] $externalLibraryPaths
	 * @return Foomo\CliCall\Compc
	 */
	public function addIncludeClasses(array $includeClasses)
	{
		$this->includeClasses = array_unique(array_merge($this->includeClasses, $includeClasses));
		return $this;
	}

	/**
	 * @param string $filename output filename
	 * @param boolean $debug
	 * @param boolean $optimize
	 * @return Foomo\CliCall\Compc
	 */
	public function compileSwc($filename, $debug=true, $optimize=false)
	{
		$this->arguments = array();
		$this->prepareArguments();
		$this->addArguments(array('-output', $filename));
		$this->addArguments(array('-debug=' . (($debug) ? 'true' : 'false'), '-optimize=' . (($optimize) ? 'true' : 'false')));
		$this->execute();
		return $this;
	}

	/**
	 * @param string $filename output filename
	 * @param boolean $debug
	 * @param boolean $optimize
	 * @return Foomo\CliCall\Compc
	 */
	public function compileSwf($filename, $debug=true, $optimize=false)
	{
		$this->arguments = array();
		$this->prepareArguments();
		$this->addArguments(array('-output', $filename));
		$this->addArguments(array('-debug=' . (($debug) ? 'true' : 'false'), '-optimize=' . (($optimize) ? 'true' : 'false')));
		$this->execute();
		return $this;
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	private function prepareArguments()
	{
		if (!empty($this->sourcePaths)) {
			$this->addArguments(array('-source-path'));
			$this->addArguments($this->sourcePaths);
		}
		if (!empty($this->externalLibraryPaths)) {
			$this->addArguments(array('-external-library-path'));
			$this->addArguments($this->externalLibraryPaths);
		}
		if (!empty($this->includeSources)) {
			$this->addArguments(array('-include-sources'));
			$this->addArguments($this->includeSources);
		}
		if (!empty($this->includeClasses)) {
			$this->addArguments(array('-include-classes'));
			$this->addArguments($this->includeClasses);
		}
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $flexsdk
	 * @param string[] $sourcePaths
	 * @param string[] $externalLibraryPaths
	 * @param string[] $includeSources
	 * @param string[] $includeClasses
	 * @return Foomo\CliCall\Compc
	 */
	public static function create($flexsdk, $sourcePaths=array(), $externalLibraryPaths=array(), $includeSources=array(), $includeClasses=array())
	{
		return new self($flexsdk, $sourcePaths, $externalLibraryPaths, $includeSources, $includeClasses);
	}
}