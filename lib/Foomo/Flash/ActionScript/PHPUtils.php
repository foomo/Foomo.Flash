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

namespace Foomo\Flash\ActionScript;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class PHPUtils
{
	//---------------------------------------------------------------------------------------------
	// ~ Static variables
	//---------------------------------------------------------------------------------------------

	/**
	 * PHP type => ActionScript tpye
	 *
	 * @var string[]
	 */
	private static $standardTypes = array(
		'int'		=> 'int',
		'integer'	=> 'int',
		'bool'		=> 'Boolean',
		'boolean'	=> 'Boolean',
		'string'	=> 'String',
		'float'		=> 'Number',
		'double'	=> 'Number',
		'mixed'		=> 'Object',
		'array'		=> 'Array',
	);

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $type
	 * @return bool
	 */
	public static function isASStandardType($type)
	{
		return isset(self::$standardTypes[\strtolower($type)]);
	}

	/**
	 * map a type between php and ActionScript
	 *
	 * @param string $type php class name | type
	 * @return string ActionScript class name | type
	 */
	public static function getASType($type)
	{
		$asType = '*';
		# check if it's a typed array
		if ((substr($type, strlen($type) - 2) == '[]')) {
			$asType = 'Array';
		} else if (self::isASStandardType($type)) {
			$asType = self::$standardTypes[\strtolower($type)];
		} else {
			$serviceObjectType = new \Foomo\Services\Reflection\ServiceObjectType($type);
			if ('' != $remoteClass = $serviceObjectType->getRemoteClass()) {
				$remoteClass = basename(str_replace('.', DIRECTORY_SEPARATOR, $remoteClass));
				$asType = $remoteClass;
			} else if (strpos($type, '\\') !== false) {
				$parts = explode('\\', $type);
				$asType = $parts[count($parts) - 1];
			} else if (class_exists($type)) {
				$asType = $type;
			}
		}
		return $asType;
	}

	/**
	 * Returns the default value for the given type
	 *
	 * @param string $type php class name | type
	 * @return string ActionScript defaults
	 */
	public static function getASTypeDefaultValue($type)
	{
		$value = 'null';
		$type = self::getASType($type);
		switch ($type) {
			case 'Boolean':
				$value = 'false';
				break;
			case 'int':
			case 'uint':
			case 'Number':
				$value = '0';
				break;
			case 'String':
				$value = "''";
				break;
		}
		return $value;
	}
}