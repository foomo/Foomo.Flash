<?php

/*
 * bestbytes-copyright-placeholder
 */

namespace Foomo\Flash\Flex;

<<<<<<< HEAD:lib/Foomo/Flash/Flex/CompilerConfig.php
class CompilerConfig extends \Foomo\Config\AbstractConfig
=======
use \Foomo\Config\AbstractConfig;
use \Foomo\Config;
use \Exception;

/**
 * flash / flex config
 */
class DomainConfig extends AbstractConfig
>>>>>>> 6a52e0a8399390519fcc5e9df4a6d44cec2bcf21:lib/Foomo/Flex/DomainConfig.php
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const NAME = 'Foomo.Flash.compilerConfig';

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
			'sourcePaths' => array(),
			'externalLibs' => array(
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
	 * @return Foomo\Flash\Flex\CompilerConfig\Entry
	 */
	public function getEntry($id)
	{
		if (!isset($this->entries[$id])) throw new \Exception('Config ' . $id . ' does not exist! Check your Foomo.Flash.flex config!');
		$entry = new \Foomo\Flash\Flex\CompilerConfig\Entry();
		$entry->id = $id;
		$entry->name = $this->entries[$id]['name'];
		$entry->sdkPath = $this->entries[$id]['sdkPath'];
		$entry->sourcePaths = $this->entries[$id]['sourcePaths'];
		$entry->externalLibs = $this->entries[$id]['externalLibs'];
		if (!is_dir($entry->sdkPath)) throw new \Exception('Configured flex SDK path does not exist ' . $entry->sdkPath);
<<<<<<< HEAD:lib/Foomo/Flash/Flex/CompilerConfig.php
		foreach ($entry->sourcePaths as $source) if (!file_exists($source)) throw new \Exception('Configured source ' . $source . ' does not exist!');
		foreach ($entry->externalLibs as $externalLib) if (!file_exists($externalLib)) throw new \Exception('Configured source ' . $source . ' does not exist!');
=======
		foreach ($entry->sourcePaths as $source) if (!file_exists($source)) throw new Exception('Configured source >' . $source . '< does not exist!');
		foreach ($entry->externalLibs as $externalLib) if (!file_exists($externalLib)) throw new Exception('Configured source >' . $source . '< does not exist!');
>>>>>>> 6a52e0a8399390519fcc5e9df4a6d44cec2bcf21:lib/Foomo/Flex/DomainConfig.php
		return $entry;
	}
}