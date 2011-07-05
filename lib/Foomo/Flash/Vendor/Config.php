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
class Config extends \Foomo\Config\AbstractConfig
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const NAME = 'Foomo.Flash.vendorConfig';

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var string[]
	 */
	public $paths = array(
		'Your.Module/vendor/your.group'
	);

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string[] $paths
	 */
	public function __construct($paths=null)
	{
		if (!is_null($paths)) $this->paths = $paths;
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return string[] all existing absolute source paths
	 */
	public function getPathnames()
	{
		$pathnames = array();
		foreach ($this->paths as $path) {
			if (substr($path, 0, 1) != DIRECTORY_SEPARATOR) {
				$pathname = \Foomo\CORE_CONFIG_DIR_MODULES . DIRECTORY_SEPARATOR . $path;
			}
			if (is_dir($pathname)) {
				$pathnames[] = $pathname;
			} else {
				trigger_error('Configured vendor path ' . $path . ' does not exist!', E_USER_WARNING);
			}
		}
		return $pathnames;
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string[] $paths
	 * @return Foomo\Flash\Vendor\Config
	 */
	public static function create($paths=null)
	{
		return new self($paths);
	}
}