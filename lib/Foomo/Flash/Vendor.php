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

namespace Foomo\Flash;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Vendor
{
	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $module
	 * @return \Foomo\Flash\Vendors\Sources
	 */
	public static function getSources($module=null)
	{
		$configs = array();
		$pathnames = array();
		if (is_null($module)) {
			$configs = array_merge($configs, \Foomo\Config::getConfs(Vendor\Config::NAME));
		} else {
			$configs[] = \Foomo\Config::getConf($module, Vendor\Config::NAME);
		}

		foreach ($configs as $config) {
			/* @var $config Foomo\Flash\Vendor\Config */
			$pathnames = array_merge($pathnames, $config->getPathnames());
		}

		return new \Foomo\Flash\Vendor\Sources($pathnames);
	}
}