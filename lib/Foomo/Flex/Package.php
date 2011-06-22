<?php

/*
 * bestbytes-copyright-placeholder
 */

namespace Foomo\Flex;

/**
 * object describing a flex source package
 *
 */
class Package
{
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * directory where the package sources are
	 *
	 * @var string
	 */
	public $srcPath;
	/**
	 * name of the package - like com.bestbytes.myPackage
	 *
	 * @var string
	 */
	public $name;
}