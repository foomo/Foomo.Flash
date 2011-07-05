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

namespace Foomo\Flash\LibraryGenerator;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Config extends \Foomo\Config\AbstractConfig
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const NAME = 'Foomo.Flash.libraryGeneratorConfig';

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	public $presets = array(
		'flex4' => array(
			'name' => 'Flex 4 (Spark)',
			'description' => '',
			'projectLibraryIds' => array('org.foomo.core', 'org.foomo.zugspitze.core', 'org.foomo.zugspitze.spark')
		),
		'flex3' => array(
			'name' => 'Flex 3 (MX)',
			'description' => '',
			'projectLibraryIds' => array('org.foomo.core', 'org.foomo.zugspitze.core', 'org.foomo.zugspitze.mx')
		),
		'air4' => array(
			'name' => 'Air Flex 4 (Spark)',
			'description' => '',
			'projectLibraryIds' => array('org.foomo.core', 'org.foomo.zugspitze.core', 'org.foomo.zugspitze.spark', 'org.foomo.zugspitze.air.spark')
		),
		'air3' => array(
			'name' => 'Air Flex 3 (MX)',
			'description' => '',
			'projectLibraryIds' => array('org.foomo.core', 'org.foomo.zugspitze.core', 'org.foomo.zugspitze.mx', 'org.foomo.zugspitze.air.mx')
		),
		'as3' => array(
			'name' => 'ActionScript (Pure)',
			'description' => '',
			'projectLibraryIds' => array('org.foomo.core', 'org.foomo.zugspitze.core', 'org.foomo.zugspitze.as3')
		)
	);

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return Foomo\Flash\LibraryGenerator\Config\Preset[]
	 */
	public function getPresets()
	{
		$presets = array();
		foreach ($this->presets as $id => $preset) $presets[] = $this->getPreset($id);
		return $presets;
	}

	/**
	 * @param string $id
	 * @return Foomo\Flash\LibraryGenerator\Config\Preset
	 */
	public function getPreset($id)
	{
		if (null == $preset = $this->presets[$id]) throw new \Exception('Preset ' . $id . ' does not exist! Check your ' . self::NAME . ' config!');
		return Config\Preset::create($id, $preset['name'], $preset['description'], $preset['projectLibraryIds']);
	}
}
