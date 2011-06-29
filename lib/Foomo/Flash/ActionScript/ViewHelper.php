<?php

namespace Foomo\Flash\ActionScript;

class ViewHelper
{
	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * myClass => PrependMyClassAppend
	 *
	 * @param string $str
	 * @param string $append
	 * @param string $prepend
	 * @return string
	 */
	public static function toClassName($str, $append=null, $prepend=null)
	{
		$className = ucfirst($str);
		if (!is_null($prepend)) $className = $prepend . $className;
		if (!is_null($append)) $className .= $append;
		return $className;
	}

	/**
	 * myContantName => PREPEND_MY_CONSTANT_NAME_APPEND
	 *
	 * @param string $opName name of the operation
	 * @return string name of the event
	 */
	public static function toConstantName($value, $append=null, $prepend=null)
	{
		$constantName = '';
		for ($i = 0; $i < strlen($value); $i++) {
			$c = substr($value, $i, 1);
			if (strtoupper($c) != $c || $i == 0) {
				$constantName .= strtoupper($c);
			} else {
				$constantName .= '_' . $c;
			}
		}
		if (!is_null($prepend)) $constantName = $prepend . $constantName;
		if (!is_null($append)) $constantName .= $append;
		return $constantName;
	}

	/**
	 * render a comment
	 *
	 * @param string $comment multi line comment text
	 * @param integer $indent number of tabs to indent
	 * @return string
	 */
	public static function renderComment($comment)
	{
		$lines = explode(PHP_EOL, $comment);
		$ret = '/**' . PHP_EOL;
		foreach($lines as $line) $ret .= ' * ' . $line . PHP_EOL;
		$ret .= ' */';
		return $ret;
	}

	/**
	 * name => value
	 *
	 * @param string[] $constants
	 * @return string
	 */
	public static function renderConstants($constants)
	{
		if (is_null($constants) || count($constants) == 0) return '';

		$output = array();
		foreach($constants as  $name => $value) {
			switch(gettype($value)) {
				case 'bool':
				case 'boolean':
					$type = 'Boolean';
					$value = ($value) ? 'true' : 'false';
					break;
				case 'int':
				case 'integer':
					$type = 'int';
					break;
				case 'float':
				case 'double':
					$type = 'Number';
					break;
				default:
					$type = 'String';
					$value = "'" . $value . "'";
					break;
			}
			$output[] = 'public static const ' . $name . ':' . $type . ' = ' . $value . ';';

		}
		return implode(PHP_EOL, $output);
	}

	/**
	 * name => type
	 *
	 * @param string[] $params
	 * @param boolean $includeType
	 * @param boolean $includeThis
	 * @return string
	 */
	public static function renderParameters($params, $includeType=true, $includeThis=false)
	{
		$output = array();
		foreach($params as $name => $type) {
			if ($includeType) {
				$output[] = $name . ':' . PHPUtils::getASType($type);
			} else if (!$includeType && !$includeThis) {
				$output[] = $name;
			} else {
				$output[] = 'this.' . $name;
			}
		}
		return implode(', ', $output);
	}

	/**
	 * name => ServiceObjectType
	 *
	 * @param $props[] $params
	 * @param boolean $includeType
	 * @param boolean $includeThis
	 * @return string
	 */
	public static function renderProperties($props, $includeType=true, $includeThis=false)
	{
		$output = array();
		foreach($props as $name => $type) {
			if ($includeType) {
				$output[] = $name . ':' . PHPUtils::getASType($type->type);
			} else if (!$includeType && !$includeThis) {
				$output[] = $name;
			} else {
				$output[] = 'this.' . $name;
			}
		}
		return implode(', ', $output);
	}
}