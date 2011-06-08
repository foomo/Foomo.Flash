<?php

/*
 * bestbytes-copyright-placeholder
 */

namespace Foomo\Flash\SwfObject2;

class Attributes {

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	private $attributes;

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	public function __construct()
	{
		$this->attributes = array();
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Uniquely identifies the Flash movie so that it can be referenced using a scripting language or by CSS.
	 *
	 * @param string $value
	 */
	public function id($value)
	{
		$this->attributes['id'] = $value;
	}

	/**
	 * Uniquely names the Flash movie so that it can be referenced using a scripting language.
	 *
	 * @param string $value
	 */
	public function name($value)
	{
		$this->attributes['name'] = $value;
	}

	/**
	 * Classifies the Flash movie so that it can be referenced using a scripting language or by CSS
	 *
	 * @param string $value
	 */
	public function styleclass($value)
	{
		$this->attributes['styleclass'] = $value;
	}

	/**
	 * @return array
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}

}