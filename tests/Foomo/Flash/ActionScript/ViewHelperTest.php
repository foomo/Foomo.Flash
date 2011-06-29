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