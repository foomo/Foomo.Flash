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

namespace Foomo\Flash;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 * @author jan <jan@bestbytes.de>
 */
class Module extends \Foomo\Modules\ModuleBase implements \Foomo\Frontend\ToolboxInterface
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	/**
	 * the name of this module
	 *
	 */
	const NAME = 'Foomo.Flash';

	//---------------------------------------------------------------------------------------------
	// ~ Overriden static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Your module needs to be set up, before being used - this is the place to do it
	 */
	public static function initializeModule()
	{
		if (!self::confExists(Vendor\Config::NAME)) {
			self::setConfig(Vendor\Config::create(array(
				'Foomo.Flash/vendor/org.foomo'
			)));
		}
	}

	/**
	 * get all the module resources
	 *
	 * @return Foomo\Modules\Resource[]
	 */
	public static function getResources()
	{
		return array(
			\Foomo\Modules\Resource\Config::getResource(self::NAME, 'Foomo.Flash.vendorConfig'),
			\Foomo\Modules\Resource\Config::getResource(self::NAME, 'Foomo.Flash.compilerConfig'),
			\Foomo\Modules\Resource\Config::getResource(self::NAME, 'Foomo.Flash.libraryGeneratorConfig'),
			\Foomo\Modules\Resource\Fs::getVarResource(\Foomo\Modules\Resource\Fs::TYPE_FOLDER, 'tmp' . DIRECTORY_SEPARATOR . self::NAME),
			\Foomo\Modules\Resource\Fs::getVarResource(\Foomo\Modules\Resource\Fs::TYPE_FOLDER, 'modules' . DIRECTORY_SEPARATOR . self::NAME)
		);
	}

	/**
	 * Get a plain text description of what this module does
	 *
	 * @return string
	 */
	public static function getDescription()
	{
		return 'Adobe Flash (tm)(r) Integration';
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return Foomo\Flash\Vendor\Config
	 */
	public static function getVendorConfig()
	{
		return self::getConfig('Foomo.Flash.vendorConfig');
	}

	/**
	 * @return Foomo\Flash\Compiler\Config
	 */
	public static function getCompilerConfig()
	{
		return self::getConfig('Foomo.Flash.compilerConfig');
	}

	/**
	 * @return Foomo\Flash\LibraryGenerator\Config
	 */
	public static function getLibraryGeneratorConfig()
	{
		return self::getConfig('Foomo.Flash.libraryGeneratorConfig');
	}

	//---------------------------------------------------------------------------------------------
	// ~ Toolbox interface methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return array
	 */
	public static function getMenu()
	{
		return array(
			\Foomo\Frontend\ToolboxConfig\MenuEntry::create('Root.Modules.Flash.LibraryGenerator', 'Library Generator', self::NAME, 'Foomo.Flash.LibraryGenerator'),
		);
	}
}
