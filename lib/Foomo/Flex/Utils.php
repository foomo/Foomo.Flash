<?php

/*
 * bestbytes-copyright-placeholder
 */

namespace Foomo\Flex;

use Foomo\CliCall;

/**
 * utilty class for compiling, packaging and stream of AS / MXML classes and packages
 *
 */
class Utils
{
	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * compile a library SWC
	 *
	 * @param string $report all compiler output etc will be appended
	 * @param string @sdkPath Path to the flex sdk to use
	 * @param array $sourcePaths where to look for sources
	 * @param array $includePaths what directories to include
	 * @param array $externalLibs what compiled libs i.e. swc¬¨¬•s to include
	 *
	 * @return string name of the swc
	 */
	public static function compileLibrarySWC(&$report, $sdkPath, $sourcePaths, $includePaths, $externalLibs = array(), $classes = array())
	{
		if (self::checkCompiler($report, $sdkPath)) {
			$swcName = tempnam(realpath(sys_get_temp_dir()), __CLASS__ . 'CompileSwc-') . '.swc';

			self::appendOptionArgs($args, '-source-path', $sourcePaths);
			self::appendOptionArgs($args, '-external-library-path', $externalLibs);
			self::appendOptionArgs($args, '-include-sources', $includePaths);
			self::appendOptionArgs($args, '-include-classes', $classes);

			/*
			$args[] = '-compute-digest=false';
			$args[] = '-include-lookup-only=true';
			$args[] = '-keep-generated-actionscript';
			$args[] = '-static-link-runtime-shared-libraries=false';
			$args[] = '-link-report';
			$args[] = '/tmp/linkreport.xml';
			$args[] = '-dump-config=/tmp/creationConfig.xml';
			 */

			$args[] = '-output';
			$args[] = $swcName;

			$cliCall = new CliCall(self::getCompilerCommand($sdkPath), $args, array('FLEX_HOME' => $sdkPath));
			$cliCall->execute();

			$report .= $cliCall->report;
			return $swcName;
		}
	}


	/**
	 * @todo do we still support this?
	 *
	 * @param string $report
	 * @param string $sdkPath
	 * @param string[] $sourcePaths
	 * @param string[] $includePaths
	 * @param string[] $externalLibs
	 * @param string[] $classes
	 * @return string
	public static function compileLibrarySwf(&$report, $sdkPath, $sourcePaths, $includePaths, $externalLibs = array(), $classes = array())
	{
		if (self::checkCompiler($report, $sdkPath)) {
			$folder = tempnam(realpath(sys_get_temp_dir()), __CLASS__ . 'CompileSwc');
			unlink($folder);
			mkdir($folder);
			self::appendOptionArgs($args, '-source-path', $sourcePaths);
			self::appendOptionArgs($args, '-external-library-path', $externalLibs);
			self::appendOptionArgs($args, '-include-sources', $includePaths);
			self::appendOptionArgs($args, '-include-classes', $classes);

			$args[] = '-directory';
			$args[] = '-output';
			$args[] = $folder;

			$cliCall = new CliCall(self::getCompilerCommand($sdkPath), $args, array('FLEX_HOME' => $sdkPath));
			$cliCall->execute();

			$report .= $cliCall->report;
			return $folder . DIRECTORY_SEPARATOR . 'library.swf';
		}
	}
	 */

	/**
	 * @todo do we still support this?
	 *
	 * @param string $report
	 * @param string @sdkPath Path to the flex sdk to use
	 * @param string[] $sourcePaths
	 * @param string[] $libraryPaths
	 * @return string
	public static function compileDocs(&$report, $sdkPath, $sourcePaths, $libraryPaths = array())
	{
		$tempnam = tempnam(realpath(sys_get_temp_dir()), 'ASDOC-');
		unlink($tempnam);
		mkdir($tempnam);
		$args = array('-source-path');
		$args = array_merge($args, $sourcePaths);
		if (count($libraryPaths) > 0) {
			$args[] = '-library-path';
			$args = array_merge($args, $libraryPaths);
		}

		$args[] = '-doc-sources';
		$args = array_merge($args, $sourcePaths);
		$args[] = '-output';
		$args[] = $tempnam;

		$call = new CliCall(self::getDocCommand($sdkPath), $args);
		$call->execute();

		$report .= $call->report;
		echo $report;
		return $tempnam;
	}
	 */

	/**
	 * @todo do we still support this?
	 *
	 * @param string $report
	 * @param string @sdkPath Path to the flex sdk to use
	 * @param string[] $sourcePaths
	 * @param string[] $classes
	 * @return string
	public static function compileClassesToSwc(&$report, $sdkPath, $sourcePaths, $classes)
	{
		if (self::checkCompiler($report, $sdkPath)) {
			$swcName = tempnam(realpath(sys_get_temp_dir()), __CLASS__ . 'CompileSwc-') . '.swc';

			$args = array('-output');
			$args[] = $swcName;
			$args[] = '-source-path';
			$args = array_merge($args, $sourcePaths);
			$args[] = '-include-classes';
			$args = array_merge($args, $classes);

			$cliCall = new CliCall(self::getCompilerCommand($sdkPath), $args, array('FLEX_HOME' => $sdkPath));
			$cliCall->execute();

			$report .= $cliCall->report;
			return $swcName;
		}
	}
	 */

	//---------------------------------------------------------------------------------------------
	// ~ Private static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * check if a compc -version call exits with 0 or not
	 *
	 * @param string $error stdError output of the call
	 * @param string @sdkPath Path to the flex sdk to use
	 * @return boolean
	 */
	private static function checkCompiler(&$error, $sdkPath)
	{
		$call = new CliCall(self::getCompilerCommand($sdkPath), array('-version'));
		$call->execute();
		if ($call->exitStatus === 0) {
			return true;
		} else {
			$error .= 'compiler check failed : ' . $call->stdErr . PHP_EOL;
			return false;
		}
	}

	/**
	 * get the flex compc
	 *
	 * @param string @sdkPath Path to the flex sdk to use
	 * @return string the compc command with its path
	 */
	private static function getCompilerCommand($sdkPath)
	{
		return $sdkPath . '/bin/compc';
	}

	/**
	 * @param string[] $args
	 * @param string $option
	 * @param string[] $optionArgs
	 */
	private static function appendOptionArgs(&$args, $option, $optionArgs)
	{
		if (count($optionArgs) > 0) {
			$args[] = $option;
			foreach ($optionArgs as $optionArg) {
				$args[] = $optionArg;
			}
		}
	}

	/**
	 * get the flex compc
	 *
	 * @param string @sdkPath Path to the flex sdk to use
	 * @return string the compc command with its path
	 */
	private static function getDocCommand($sdkPath)
	{
		return $sdkPath . '/bin/asdoc';
	}
}