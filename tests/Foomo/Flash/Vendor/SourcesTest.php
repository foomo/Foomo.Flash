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

namespace Foomo\Flash\Vendor;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class SourcesTest extends \PHPUnit_Framework_TestCase
{
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var Foomo\Flash\Vendor\Sources
	 */
	private $sources;

	//---------------------------------------------------------------------------------------------
	// ~ Setup
	//---------------------------------------------------------------------------------------------

	public function setUp()
	{
		$this->sources = new \Foomo\Flash\Vendor\Sources(array(\Foomo\Flash\Module::getVendorDir('org.foomo')));
	}

	//---------------------------------------------------------------------------------------------
	// ~ Test methods
	//---------------------------------------------------------------------------------------------

	public function testUpdateProjects()
	{
		$this->sources = new \Foomo\Flash\Vendor\Sources(array(\Foomo\Flash\Module::getVendorDir('org.foomo')), false);
		$this->assertTrue((count($this->sources->getLibraryProjects()) == 0));
		$this->sources->updateProjects();
		$this->assertTrue((count($this->sources->getLibraryProjects()) == 0));
		$this->assertTrue((count($this->sources->getLibraryProjects(false)) > 0));
	}

	public function testGetLibraryProject()
	{
		$this->assertNotNull($this->sources->getLibraryProject(\Foomo\Flash\Tests\VendorHelper::CORE_LIBRARY_ID));
	}

	public function testGetLibraryProjects()
	{
		$this->assertEquals(\Foomo\Flash\Tests\VendorHelper::LIBRARY_COUNT, count($this->sources->getLibraryProjects(false)));
	}
}