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
}