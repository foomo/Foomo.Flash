<?php

/*
 * bestbytes-copyright-placeholder
 */

namespace Foomo\Flash\SwfObject2;

class Params {
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const QUALITY_BEST = 'best';
	const QUALITY_HIGH = 'high';
	const QUALITY_MEDIUM = 'medium';
	const QUALITY_AUTO_HIGH = 'autoHigh';
	const QUALITY_AUTO_LOW = 'autoLow';
	const QUALITY_LOW = 'low';

	const SCALE_SHOW_ALL = 'showall';
	const SCALE_NO_BORDER = 'noborder';
	const SCALE_EXACT_FIT = 'exactfit';
	const SCALE_NO_SCALE = 'noscale';

	const SALIGN_TL = 'tl';
	const SALIGN_TR = 'tr';
	const SALIGN_BL = 'bl';
	const SALIGN_BR = 'br';
	const SALIGN_L = 'l';
	const SALIGN_T = 't';
	const SALIGN_R = 'r';
	const SALIGN_B = 'b';

	const WMODE_WINDOW = 'window';
	const WMODE_OPAQUE = 'opaque';
	const WMODE_TRANSPARENT = 'transparent';
	const WMODE_DIRECT = 'direct';
	const WMODE_GPU = 'gpu';

	const ALLOW_NETWORKING_ALL = 'all';
	const ALLOW_NETWORKING_INTERNAL = 'internal';
	const ALLOW_NETWORKING_NONE = 'none';

	const ALLLOW_SCRIPT_ACCESS_ALWAYS = 'always';
	const ALLLOW_SCRIPT_ACCESS_SAME_DOMAIN = 'sameDomain';
	const ALLLOW_SCRIPT_ACCESS_NEVER = 'never';

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	private $params;

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	public function __construct()
	{
		$this->params = array();
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Specifies whether the movie begins playing immediately on loading in the browser.
	 * The default value is true if this attribute is omitted.
	 *
	 * @param boolean $value
	 */
	public function play($value)
	{
		$this->param['play'] = $value;
	}

	/**
	 * Specifies whether the movie repeats indefinitely or stops when it reaches the last frame.
	 * The default value is true if this attribute is omitted.
	 *
	 * @param boolean $value
	 */
	public function loop($value)
	{
		$this->param['loop'] = $value;
	}

	/**
	 * Shows a shortcut menu when users right-click (Windows) or control-click (Macintosh) the SWF file.
	 * To show only About Flash in the shortcut menu, deselect this option.
	 * By default, this option is set to true.
	 *
	 * @param boolean $value
	 */
	public function menu($value)
	{
		$this->param['menu'] = $value;
	}

	/**
	 * Specifies the trade-off between processing time and appearance.
	 * The default value is 'high' if this attribute is omitted.
	 *
	 * @param string $value
	 */
	public function quality($value)
	{
		$this->param['quality'] = $value;
	}

	/**
	 * Specifies scaling, aspect ratio, borders, distortion and cropping for if you have changed the document's original width and height.
	 *
	 * @param string $value
	 */
	public function scale($value)
	{
		$this->param['scale'] = $value;
	}

	/**
	 * Specifies where the content is placed within the application window and how it is cropped.
	 *
	 * @param string $value
	 */
	public function salign($value)
	{
		$this->param['salign'] = $value;
	}

	/**
	 * Sets the Window Mode property of the Flash movie for transparency, layering, and positioning in the browser.
	 * The default value is 'window' if this attribute is omitted.
	 *
	 * @param string $value
	 */
	public function wmode($value)
	{
		$this->param['wmode'] = $value;
	}

	/**
	 * Hexadecimal RGB value in the format #RRGGBB, which specifies the background color of the movie,
	 * which will override the background color setting specified in the Flash file.
	 *
	 * @param string $value
	 */
	public function bgColor($value)
	{
		$this->param['bgcolor'] = $value;
	}

	/**
	 * Specifies whether static text objects that the Device Font option has not been selected for will be drawn using device fonts anyway,
	 * if the necessary fonts are available from the operating system.
	 *
	 * @param boolean $value
	 */
	public function deviceFont($value)
	{
		$this->param['devicefont'] = $value;
	}

	/**
	 * Specifies whether users are allowed to use the Tab key to move keyboard focus out of a Flash movie and into the surrounding HTML
	 * (or the browser, if there is nothing focusable in the HTML following the Flash movie).
	 * The default value is true if this attribute is omitted.
	 *
	 * @param boolean $value
	 */
	public function seamlessTabbing($value)
	{
		$this->param['seamlesstabbing'] = $value;
	}

	/**
	 * Specifies whether the browser should start Java when loading the Flash Player for the first time.
	 * The default value is false if this attribute is omitted. If you use JavaScript and Flash on the same page,
	 * Java must be running for the FSCommand to work.
	 *
	 * @param boolean $value
	 */
	public function swLiveConnect($value)
	{
		$this->param['swliveconnect'] = $value;
	}

	/**
	 * Enables full-screen mode.
	 * The default value is false if this attribute is omitted.
	 * You must have version 9,0,28,0 or greater of Flash Player installed to use full-screen mode.
	 *
	 * @param boolean $value
	 */
	public function allowFullScreen($value)
	{
		$this->param['allowfullscreen'] = $value;
	}

	/**
	 * Controls the ability to perform outbound scripting from within a Flash SWF.
	 * The default value is 'always' if this attribute is omitted.
	 *
	 * @param string $value
	 */
	public function allowScriptAccess($value)
	{
		$this->param['allowscriptaccess'] = $value;
	}

	/**
	 * Controls a SWF file's access to network functionality.
	 * The default value is 'all' if this attribute is omitted.
	 *
	 * @param string $value
	 */
	public function allowNetworking($value)
	{
		$this->param['allownetworking'] = $value;
	}

	/**
	 * Specifies the base directory or URL used to resolve all relative path statements in the Flash Player movie.
	 * This attribute is helpful when your Flash Player movies are kept in a different directory from your other files.
	 *
	 * @param string $value
	 */
	public function base($value)
	{
		$this->param['base'] = $value;
	}

	/**
	 * @return array
	 */
	public function getParams()
	{
		return $this->param;
	}

}