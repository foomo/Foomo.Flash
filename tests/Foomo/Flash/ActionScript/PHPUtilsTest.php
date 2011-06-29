<?php

namespace Foomo\Flash\ActionScript;

class PHPUtilsTest extends \PHPUnit_Framework_TestCase
{
	//---------------------------------------------------------------------------------------------
	// ~ Initialization
	//---------------------------------------------------------------------------------------------

	public function setUp()
	{
   	}

	//---------------------------------------------------------------------------------------------
	// ~ Test methods
	//---------------------------------------------------------------------------------------------

	public function testIsASStandardType()
	{
		$this->assertTrue(PHPUtils::isASStandardType('bool'));
		$this->assertTrue(PHPUtils::isASStandardType('boolean'));
		$this->assertTrue(PHPUtils::isASStandardType('string'));
		$this->assertTrue(PHPUtils::isASStandardType('float'));
		$this->assertTrue(PHPUtils::isASStandardType('int'));
		$this->assertTrue(PHPUtils::isASStandardType('integer'));
		$this->assertTrue(PHPUtils::isASStandardType('double'));
		$this->assertTrue(PHPUtils::isASStandardType('mixed'));
		$this->assertTrue(PHPUtils::isASStandardType('array'));
		$this->assertFalse(PHPUtils::isASStandardType('Exception'));
		$this->assertFalse(PHPUtils::isASStandardType('Foomo\\Services\\PHPUtils'));
   	}

	public function testGetASType()
	{
		$this->assertEquals(PHPUtils::getASType('bool'), 'Boolean');
		$this->assertEquals(PHPUtils::getASType('string'), 'String');
		$this->assertEquals(PHPUtils::getASType('array'), 'Array');
		$this->assertEquals(PHPUtils::getASType('int'), 'int');
		$this->assertEquals(PHPUtils::getASType('float'), 'Number');
		$this->assertEquals(PHPUtils::getASType('double'), 'Number');
		$this->assertEquals(PHPUtils::getASType('mixed'), 'Object');
		$this->assertEquals(PHPUtils::getASType('Exception'), 'Exception');
		$this->assertEquals(PHPUtils::getASType('Foomo\\Services\\PHPUtils'), 'PHPUtils');
	}

	public function testGetASTypeDefaultValue()
	{
		$this->assertEquals(PHPUtils::getASTypeDefaultValue('bool'), 'false');
		$this->assertEquals(PHPUtils::getASTypeDefaultValue('int'), '0');
		$this->assertEquals(PHPUtils::getASTypeDefaultValue('float'), '0');
		$this->assertEquals(PHPUtils::getASTypeDefaultValue('string'), "''");
		$this->assertEquals(PHPUtils::getASTypeDefaultValue('array'), 'null');
		$this->assertEquals(PHPUtils::getASTypeDefaultValue('mixed'), 'null');
		$this->assertEquals(PHPUtils::getASTypeDefaultValue('Exception'), 'null');
		$this->assertEquals(PHPUtils::getASTypeDefaultValue('Foomo\\Services\\PHPUtils'), 'null');
	}
}