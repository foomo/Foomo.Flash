<?php

namespace Foomo\CliCall;

class Asdoc extends \Foomo\CliCall
{
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * Path to the flexsdk
	 *
	 * @var string
	 */
	public $flexsdk;
	/**
	 * @var string[]
	 */
	public $sourcePaths = array();
	/**
	 * @var string[]
	 */
	public $libraryPaths = array();
	/**
	 * @var string[]
	 */
	public $docSources = array();

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $flexsdk
	 * @param string[] $sourcePaths
	 * @param string[] $libraryPaths
	 * @param string[] $docSources
	 */
	public function __construct($flexsdk, $sourcePaths=array(), $libraryPaths=array(), $docSources=array())
	{
		$this->flexsdk = $flexsdk;
		$this->addSourcePaths($sourcePaths);
		$this->addLibraryPaths($libraryPaths);
		$this->addDocSources($docSources);
		parent::__construct($this->flexsdk . '/bin/compc');
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string[] $sourcePaths
	 * @return Foomo\CliCall\Asdoc
	 */
	public function addSourcePaths(array $sourcePaths)
	{
		$this->sourcePaths = array_unique(array_merge($this->sourcePaths, $sourcePaths));
		return $this;
	}

	/**
	 * @param string[] $libraryPaths
	 * @return Foomo\CliCall\Asdoc
	 */
	public function addLibraryPaths(array $libraryPaths)
	{
		$this->libraryPaths = array_unique(array_merge($this->libraryPaths, $libraryPaths));
		return $this;
	}

	/**
	 * @param string[] $docSources
	 * @return Foomo\CliCall\Asdoc
	 */
	public function addDocSources(array $docSources)
	{
		$this->docSources = array_unique(array_merge($this->docSources, $docSources));
		return $this;
	}

	/**
	 * @param string $pathname
	 * @return Foomo\CliCall\Asdoc
	 */
	public function compileDoc($pathname)
	{
		$this->prepareArguments();
		$this->addArguments(array('-output', $pathname));
		$this->execute();
		return $this;
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	private function prepareArguments()
	{
		if (!empty($this->sourcePaths)) {
			$this->addArguments(array('-source-path'));
			$this->addArguments($this->sourcePaths);
		}
		if (!empty($this->libraryPaths)) {
			$this->addArguments(array('-library-path'));
			$this->addArguments($this->libraryPaths);
		}
		if (!empty($this->docSources)) {
			$this->addArguments(array('-doc-sources'));
			$this->addArguments($this->docSources);
		}
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $flexsdk
	 * @param string[] $sourcePaths
	 * @param string[] $libraryPaths
	 * @param string[] $docSources
	 * @return Foomo\CliCall\Asdoc
	 */
	public static function create($flexsdk, $sourcePaths=array(), $libraryPaths=array(), $docSources=array())
	{
		return new self($flexsdk, $sourcePaths, $libraryPaths, $docSources);
	}
}