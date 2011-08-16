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

namespace Foomo\Flash\Compiler;

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

	const NAME = 'Foomo.Flash.compilerConfig';

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * Additional source paths
	 *
	 * @var string[]
	 */
	public $entries = array(
		'default' => array(
			'name' => 'Default Flex SDK',
			'sdkPath' => '/usr/local/flex_sdk',
			'sourcePaths' => array(),
			'externalLibs' => array(
				'/usr/local/flex_sdk/frameworks/libs',
				'/usr/local/flex_sdk/frameworks/libs/air',
				'/usr/local/flex_sdk/frameworks/libs/player/10'
			)
		)
	);

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return Foomo\Flash\Compiler\Config\Entry
	 */
	public function getEntry($id)
	{
		if (null == $entry = $this->entries[$id]) trigger_error('Config ' . $id . ' does not exist! Check your Foomo.Flash.flex config!', E_USER_ERROR);
		$ret = \Foomo\Flash\Compiler\Config\Entry::create(
				$id,
				$entry['name'],
				$entry['sdkPath'],
				$entry['sourcePaths'],
				$entry['externalLibs']
		);
		if (!is_dir($ret->sdkPath)) throw new \Exception('Configured flex SDK path does not exist ' . $ret->sdkPath);
		foreach ($ret->sourcePaths as $source) if (!file_exists($source)) throw new \Exception('Configured source ' . $source . ' does not exist!');
		foreach ($ret->externalLibs as $externalLib) if (!file_exists($externalLib)) throw new \Exception('Configured source ' . $source . ' does not exist!');
		return $ret;
	}

	/**
	 * @return Foomo\Flash\Compiler\Config\Entry[]
	 */
	public function getEntries()
	{
		$entries = array();
		foreach ($this->entries as $id => $entry) $entries[] = $this->getEntry($id);
		return $entries;
	}
}
