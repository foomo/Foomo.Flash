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
class DomainConfig extends AbstractConfig
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const NAME = 'Foomo.Flash.flex';

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * Additional source paths
	 *
	 * @var string[]
	 */
	public $entries = array(
		'default' => array(
			'name' => 'Default Flex SDK',
			'sdkPath' => '/usr/local/flex_sdk',
			'sourcePaths' => array(
				'/usr/local/flex_sdk/frameworks/libs',
				'/usr/local/flex_sdk/frameworks/libs/air',
				'/usr/local/flex_sdk/frameworks/libs/player/10'
			)
		)
	);

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return Foomo\Flex\DomainConfig\Entry
	 */
	public function getEntry($id)
	{
		if (!isset($this->entries[$id])) throw new \Exception('Config ' . $id . ' does not exist! Check your Foomo.Flash.flex config!');
		$entry = new DomainConfig\Entry();
		$entry->id = $id;
		$entry->name = $this->entries[$id]['name'];
		$entry->sdkPath = $this->entries[$id]['sdkPath'];
		$entry->sourcePaths = $this->entries[$id]['sourcePaths'];
		if (!is_dir($entry->sdkPath)) throw new \Exception('Configured flex SDK path does not exist ' . $entry->sdkPath);
		foreach ($entry->sourcePaths as $source) if (!file_exists($source)) throw new Exception('Configured source ' . $source . ' does not exist!');
		return $entry;
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return \Foomo\Flex\DomainConfig
	 */
	public static function getInstance()
	{
		return Config::getConf(\Foomo\Flash\Module::NAME, self::NAME);
	}
}