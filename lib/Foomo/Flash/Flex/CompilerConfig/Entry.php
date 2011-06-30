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

namespace Foomo\Flash\Flex\CompilerConfig;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Entry
{
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var string
	 */
	public $id;
	/**
	 * @var string
	 */
	public $name;
	/**
	 * @var string
	 */
	public $sdkPath;
	/**
	 * @var string[]
	 */
	public $sourcePaths = array();
	/**
	 * @var string[]
	 */
	public $externalLibs = array();

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $id
	 * @param string $name
	 * @param string $sdkPath
	 * @param array $sourcePaths
	 * @param array $externalLibs
	 */
	public function __construct($id, $name, $sdkPath, array $sourcePaths=array(), array $externalLibs=array())
	{
		$this->id = $id;
		$this->name = $name;
		$this->sdkPath = $sdkPath;
		$this->sourcePaths = $sourceFilename;
		$this->externalLibs = $externalLibs;
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $id
	 * @param string $name
	 * @param string $sdkPath
	 * @param array $sourcePaths
	 * @param array $externalLibs
	 */
	public static function create($id, $name, $sdkPath, array $sourcePaths=array(), array $externalLibs=array())
	{
		return new self($id, $name, $sdkPath, $sourcePaths, $externalLibs);
	}
}