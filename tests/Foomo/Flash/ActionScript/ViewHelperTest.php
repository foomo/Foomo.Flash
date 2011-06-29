<?php

namespace Foomo\Flash\ActionScript;

class ViewHelperTest extends \PHPUnit_Framework_TestCase
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

	public function testToClassName()
	{
		$this->assertEquals(ViewHelper::toClassName('my'), 'My');
		$this->assertEquals(ViewHelper::toClassName('myClass'), 'MyClass');
		$this->assertEquals(ViewHelper::toClassName('myClass', 'Append'), 'MyClassAppend');
		$this->assertEquals(ViewHelper::toClassName('myClass', null, 'Prepend'), 'PrependMyClass');
		$this->assertEquals(ViewHelper::toClassName('myClass', 'Append', 'Prepend'), 'PrependMyClassAppend');
   	}

	public function testToConstantName()
	{
		$this->assertEquals(ViewHelper::toConstantName('my'), 'MY');
		$this->assertEquals(ViewHelper::toConstantName('myConstant'), 'MY_CONSTANT');
		$this->assertEquals(ViewHelper::toConstantName('MyConstant'), 'MY_CONSTANT');
		$this->assertEquals(ViewHelper::toConstantName('MyConstant', '_APPEND'), 'MY_CONSTANT_APPEND');
		$this->assertEquals(ViewHelper::toConstantName('MyConstant', null, 'PREPEND_'), 'PREPEND_MY_CONSTANT');
		$this->assertEquals(ViewHelper::toConstantName('MyConstant', '_APPEND', 'PREPEND_'), 'PREPEND_MY_CONSTANT_APPEND');
	}

	public function testRenderComment()
	{
		$this->assertEquals(str_replace(PHP_EOL, '', ViewHelper::renderComment('my comment')), '/** * my comment */');
	}

	public function testRenderConstants()
	{
		$this->assertEquals(ViewHelper::renderConstants(array('MY_CONSTANT' => true)), 'public static const MY_CONSTANT:Boolean = true;');
		$this->assertEquals(ViewHelper::renderConstants(array('MY_CONSTANT' => 'string')), 'public static const MY_CONSTANT:String = \'string\';');
	}
}