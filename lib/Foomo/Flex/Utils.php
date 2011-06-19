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
class Utils {

	private static $additionalCompilerArgs = array();

	public static function resetCompilerArgs()
	{
		self::$additionalCompilerArgs = array();
	}

	public static function addCompilerArg($arg)
	{
		self::$additionalCompilerArgs[] = $arg;
	}

	/**
	 * compile a library SWC
	 *
	 * @param string $report all compiler output etc will be appended
	 * @param array $sourcePaths where to look for sources
	 * @param array $includePaths what directories to include
	 * @param array $externalLibs what compiled libs i.e. swc¬¨¬•s to include
	 *
	 * @return string name of the swc
	 */
	public static function compileLibrarySWC(&$report, $sourcePaths, $includePaths, $externalLibs = array(), $classes = array())
	{
		if (self::checkCompiler($report)) {
			$swcName = tempnam(realpath(sys_get_temp_dir()), __CLASS__ . 'CompileSwc-') . '.swc';

			self::appendOptionArgs($args, '-source-path', $sourcePaths);
			self::appendOptionArgs($args, '-external-library-path', $externalLibs);
			self::appendOptionArgs($args, '-include-sources', $includePaths);
			self::appendOptionArgs($args, '-include-classes', $classes);

			//$args[] = '-compute-digest=false';
			//$args[] = '-include-lookup-only=true';
			//$args[] = '-keep-generated-actionscript';
			//$args[] = '-static-link-runtime-shared-libraries=false';
			//$args[] = '-link-report';
			//$args[] = '/tmp/linkreport.xml';
			//$args[] = '-dump-config=/tmp/creationConfig.xml';

			self::mergeCompilerArgs($args);

			$args[] = '-output';
			$args[] = $swcName;



			$cliCall = new CliCall(
							self::getCompilerCommand(),
							$args,
							array(
								'FLEX_HOME' => Settings::$FLEX_HOME
							)
			);
			$cliCall->execute();
			$report .= $cliCall->report;
			return $swcName;
		}
	}

	private static function mergeCompilerArgs(&$args)
	{
		foreach (self::$additionalCompilerArgs as $additionalComilerArg) {
			$args[] = $additionalComilerArg;
		}
	}

	public static function compileLibrarySwf(&$report, $sourcePaths, $includePaths, $externalLibs = array(), $classes = array())
	{
		if (self::checkCompiler($report)) {
			$folder = tempnam(realpath(sys_get_temp_dir()), __CLASS__ . 'CompileSwc');
			unlink($folder);
			mkdir($folder);
			self::appendOptionArgs($args, '-source-path', $sourcePaths);
			self::appendOptionArgs($args, '-external-library-path', $externalLibs);
			self::appendOptionArgs($args, '-include-sources', $includePaths);
			self::appendOptionArgs($args, '-include-classes', $classes);

			foreach (self::$additionalCompilerArgs as $additionalComilerArg) {
				$args[] = $additionalComilerArg;
			}

			self::mergeCompilerArgs($args);

			$args[] = '-directory';
			$args[] = '-output';
			$args[] = $folder;


			$cliCall = new CliCall(
							self::getCompilerCommand(),
							$args,
							array(
								'FLEX_HOME' => Settings::$FLEX_HOME
							)
			);
			$cliCall->execute();
			$report .= $cliCall->report;
			return $folder . DIRECTORY_SEPARATOR . 'library.swf';
		}
	}

	private static function checkEnv(&$report)
	{
		if (is_null(Settings::$FLEX_HOME)) {
			$error = 'Foomo\Flash\Settings::$FLEX_HOME is not set';
			trigger_error($error, E_USER_WARING);
			$report .= $error . PHP_EOL;
			return false;
		} else {
			return true;
		}
	}

	private static function appendOptionArgs(&$args, $option, $optionArgs)
	{
		if (count($optionArgs) > 0) {
			$args[] = $option;
			foreach ($optionArgs as $optionArg) {
				$args[] = $optionArg;
			}
		}
	}

	public static function compileDocs(&$report, $sourcePaths, $libraryPaths = array())
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

		self::mergeCompilerArgs($args);

		$args[] = '-doc-sources';
		$args = array_merge($args, $sourcePaths);
		$args[] = '-output';
		$args[] = $tempnam;

		$call = new CliCall(
						self::getDocCommand(),
						$args
		);
		$call->execute();
		$report .= $call->report;
		echo $report;
		return $tempnam;
	}

	public static function compileClassesToSwc(&$report, $sourcePaths, $classes)
	{
		if (self::checkCompiler($report)) {
			$swcName = tempnam(realpath(sys_get_temp_dir()), __CLASS__ . 'CompileSwc-') . '.swc';

			$args = array('-output');
			$args[] = $swcName;
			$args[] = '-source-path';
			$args = array_merge($args, $sourcePaths);
			$args[] = '-include-classes';
			$args = array_merge($args, $classes);
			self::mergeCompilerArgs($args);
			$cliCall = new CliCall(
							self::getCompilerCommand(),
							$args,
							array(
								'FLEX_HOME' => Settings::$FLEX_HOME
							)
			);
			$cliCall->execute();
			$report .= $cliCall->report;
			return $swcName;
		}
	}

	/**
	 * get the flex compc
	 *
	 * @return string the compc command with its path
	 */
	private static function getCompilerCommand()
	{
		return Settings::$FLEX_HOME . '/bin/compc';
	}

	/**
	 * get the flex compc
	 *
	 * @return string the compc command with its path
	 */
	private static function getDocCommand()
	{
		return Settings::$FLEX_HOME . '/bin/asdoc';
	}

	/**
	 * check if a compc -version call exits with 0 or not
	 *
	 * @param string $error stdError output of the call
	 *
	 * @return boolean
	 */
	public static function checkCompiler(&$error)
	{
		if (self::checkEnv($error)) {
			$call = new CliCall(
							self::getCompilerCommand(),
							array(
								'-version'
							)
			);
			$call->execute();
			//$error = $call->stdErr;
			if ($call->exitStatus === 0) {
				return true;
			} else {
				$error .= 'compiler check failed : ' . $call->stdErr . PHP_EOL;
				return false;
			}
		} else {
			return false;
		}
	}


	/**
	 * stream a source archive
	 *
	 * @param string $fileName of the tgz
	 */
	public static function streamTgz($filename)
	{
		self::stream($filename, 'application/x-compressed');
	}

	/**
	 * stream a swc
	 *
	 * @param string $fileName of the swc
	 */
	public static function streamSWC($filename)
	{
		self::stream($filename, 'application/octet-stream');
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $filename
	 * @param string $mime
	 */
	private static function stream($filename, $mime)
	{
		if (!\Foomo\Utils::streamFile($filename, basename($filename), $mime, true)) {
			die('resource not available : ' . $filename);
		}
	}
}