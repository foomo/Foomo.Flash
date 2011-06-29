<?php

/*
 * bestbytes-copyright-placeholder
 */

namespace Foomo\Flash;

use Foomo\Modules\ModuleBase;

/**
 * Module flash for radact
 */
class Module extends ModuleBase
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
	}

	/**
	 * get all the module resources
	 *
	 * @return Foomo\Modules\Resource[]
	 */
	public static function getResources()
	{
		return array(
			\Foomo\Modules\Resource\Config::getResource(self::NAME, 'Foomo.Flash.compilerConfig'),
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
	 * @return Foomo\Flash\Flex\CompilerConfig
	 */
	public static function getCompilerConfig()
	{
		return self::getConfig('Foomo.Flash.compilerConfig');
	}
}
