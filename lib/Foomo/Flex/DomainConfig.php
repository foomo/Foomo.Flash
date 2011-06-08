<?php

/*
 * bestbytes-copyright-placeholder
 */

namespace Foomo\Flex;

use \Foomo\Config\AbstractConfig;
use \Foomo\Config;

/**
 * flash / flex config
 */
class DomainConfig extends AbstractConfig {
	const NAME = 'Foomo.Flash.flex';
	/**
	 * home
	 * 
	 * @var string
	 */
	public $home = '/usr/local/flex_sdk';
	public $generatedSrcDir;
	public $srcDirs = array();

	/**
	 * @return \Foomo\Flex\DomainConfig
	 */
	public static function getInstance()
	{
		return Config::getConf(\Foomo\Flash\Module::NAME, self::NAME);
	}

}