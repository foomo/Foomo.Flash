<?php

namespace Foomo\Flash\ActionScript;

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