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

namespace Foomo\Flash\SwfObject2;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 * @author jan <jan@bestbytes.de>
 */
class Attributes
{

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var array
	 */
	private $attributes;

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
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