<?php

namespace Foomo\Flex\DomainConfig;

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
}