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

use \Foomo\Flash\SwfObject2\FlashVars;
use \Foomo\Flash\SwfObject2\Attributes;
use \Foomo\Flash\SwfObject2\Params;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 * @author jan <jan@bestbytes.de>
 */
class SWFObject2 {
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var string
	 */
	private $swf;
	/**
	 * @var string
	 */
	private $containerId;
	/**
	 * @var string
	 */
	private $width;
	/**
	 * @var string
	 */
	private $height;
	/**
	 * @var string
	 */
	private $version;
	/**
	 * @var mixed
	 */
	private $expressInstallSWF;
	/**
	 * @var \Foomo\Flash\SwfObject2\FlashVars
	 */
	private $flashVars;
	/**
	 * @var \Foomo\Flash\SwfObject2\Params
	 */
	private $params;
	/**
	 * @var \Foomo\Flash\SwfObject2\Attributes
	 */
	private $attributes;

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $swf
	 * @param string $containerId
	 * @param string $width
	 * @param string $height
	 * @param string $version
	 * @param string $expressInstallSWF
	 * @param \Foomo\Flash\SwfObject2\FlashVars $flashVars
	 * @param \Foomo\Flash\SwfObject2\Params $params
	 * @param \Foomo\Flash\SwfObject2\Attributes $attributes
	 */
	public function __construct($swf, $containerId, $width, $height, $version, $expressInstallSWF=null, FlashVars $flashVars=null, Params $params=null, Attributes $attributes=null)
	{
		$this->swf = $swf;
		$this->containerId = $containerId;
		$this->width = $width;
		$this->height = $height;
		$this->version = $version;
		$this->expressInstallSWF = (is_null($expressInstallSWF)) ? false : '"' . $expressInstallSWF . '"';
		$this->flashVars = (is_null($flashVars)) ? new FlashVars() : $flashVars;
		$this->params = (is_null($params)) ? new Params() : $params;
		$this->attributes = (is_null($attributes)) ? new Attributes() : $attributes;
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * return string JavaScript
	 */
	public function embedSWF()
	{
		static $i = 0;
		$js = '';
		$js .= 'var flashvars_' . $i . '  = ' . json_encode($this->flashVars->getVars()) . ';' . PHP_EOL;
		$js .= 'var params_' . $i . '     = ' . json_encode($this->params->getParams()) . ';' . PHP_EOL;
		$js .= 'var attributes_' . $i . ' = ' . json_encode($this->attributes->getAttributes()) . ';' . PHP_EOL;
		$js .= 'var so_' . $i . '         = swfobject.embedSWF("' . $this->swf . '", "' . $this->containerId . '", "' . $this->width . '", "' . $this->height . '", "' . $this->version . '", ' . $this->expressInstallSWF . ', flashvars_' . $i . ', params_' . $i . ', attributes_' . $i . ');' . PHP_EOL;
		$i++;
		return $js;
	}
}
