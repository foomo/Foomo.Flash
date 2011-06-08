<?php

/*
 * bestbytes-copyright-placeholder
 */

namespace Foomo\Flash;

use Foomo\Modules\ModuleBase;

/**
 * Module flash for radact
 * Created 2010-12-07 17:37:56
 */
class Module extends ModuleBase {
	/**
	 * the name of this module
	 *
	 */
	const NAME = 'Foomo.Flash';

	/**
	 * Your module needs to be set up, before being used - this is the place to do it
	 */
	public static function initializeModule()
	{
		$flexConfig = \Foomo\Flex\DomainConfig::getInstance();
		if($flexConfig) {
			\Foomo\Flex\Settings::$FLEX_HOME = $flexConfig->home;
		}
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

	/**
	 * get a translation object for a resource in your module
	 *
	 * @param string $resourceName name of the resource will point to /path/to/moduleRoot/locale/<locale>/<resourceName>.yml
	 * @param string[] $localeChain ordered preferences for your translations like array('en_US', 'de_DE, ...) or array('en', 'de') or ...
	 *
	 * @return \Foomo\Translation
	 */
	public static function getTranslation($resourceName, $localeChain = null)
	{
		return \Foomo\Translation::getModuleTranslation(self::NAME, $resourceName, $localeChain);
	}

	/**
	 * get all the module resources
	 *
	 * @return \Foomo\Modules\Resource[]
	 */
	public static function getResources()
	{
		return array(
			// get a run mode independent folder var/<runMode>/test
			// \Foomo\Modules\Resource\Fs::getVarResource(\Foomo\Modules\Resource\Fs::TYPE_FOLDER, 'test'),
			// and a file in it
			// \Foomo\Modules\Resource\Fs::getVarResource(\Foomo\Modules\Resource\Fs::TYPE_File, 'test' . DIRECTORY_SEPARATOR . 'someFile'),
			// request a cache resource
			// \Foomo\Modules\Resource\Fs::getCacheResource(\Foomo\Modules\Resource\Fs::TYPE_FOLDER, 'navigationLeaves'),
			// a database configuration
			// \Foomo\Modules\Resource\Config::getResource(self::NAME, 'Foomo.Flash.flex')
		);
	}

}