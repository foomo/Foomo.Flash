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
class LibraryGenerator
{
	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $libraryProjectIds
	 * @param string $configId
	 * @param string $report
	 * @return string SWC file name
	 */
	public static function compile($libraryProjectIds, $configId, &$report)
	{
		$flexConfigEntry = \Foomo\Flash\Module::getCompilerConfig()->getEntry($configId);

		$compc = \Foomo\CliCall\Compc::create(
			$flexConfigEntry->sdkPath,
			$flexConfigEntry->sourcePaths,
			$flexConfigEntry->externalLibs,
			$flexConfigEntry->sourcePaths
		);

		$includePaths = $flexConfigEntry->sourcePaths;
		$sourcePaths = $flexConfigEntry->sourcePaths;
		$externalLibs = $flexConfigEntry->externalLibs;

		# set compc's paths
		self::includeLibrayIds($libraryProjectIds, \Foomo\Flash\Vendor::getSources(), $compc);

		# get unigue file id
		$filenameId = \implode('-', $libraryProjectIds) . '-' . $configId;

		# get filename
		$filename = \Foomo\Flash\Module::getVarDir('libraries') . '/' . \md5($filenameId);

		# check if file exists
		if (\file_exists($filename)) {
			# do return filename if compiled version is newer than it's sources
			$deps = \array_unique(\array_merge($compc->sourcePaths, $compc->externalLibraryPaths));
			$cmd = \Foomo\CliCall\Find::create($deps)->type('f')->newer($filename)->execute();
			if (empty($cmd->stdOut)) return $filename;
		}

		# update report
		$report .= $compc->compileSwc($filename)->report;

		# compile
		if ($compc->exitStatus !== 0 || !file_exists($filename)) {
			throw new \Exception(
					'Adobe Compc (Flex Component Compiler) failed to create the swc.' . PHP_EOL .
					PHP_EOL .
					'This typically means, that there are incomplete phpDoc comments for your service classes method' . PHP_EOL .
					'parameters and / or return values and / or the corresponding value objects.' . PHP_EOL .
					'The resulting action script will have errors like' . PHP_EOL .
					PHP_EOL .
					'// missing type declaration' . PHP_EOL .
					'public var lastResult:;' . PHP_EOL .
					PHP_EOL .
					'see also what the flex compiler put to stdErr' . PHP_EOL .
					PHP_EOL .
					$report,
					1
			);
		}

		return $filename;
	}

	/**
	 * @return string Filename
	 */
	public static function generateAntBuildFile($name, $libraryProjectIds, $libraryProjects, $configId, $sources)
	{
		$sdk = \Foomo\Flash\Module::getCompilerConfig()->getEntry($configId);
		$view = Module::getView(
			'Foomo\\Flash\\LibraryGenerator',
			'LibraryGenerator/AntBuildFile',
			array(
				'configId' => $sdk->id,
				'libraryProjectIds' => $libraryProjectIds,
				'libraryProjects' => $libraryProjects,
				'sources' => $sources,
				'name' => $name
			)
		);
		$filename = tempnam(\Foomo\Flash\Module::getTempDir(), 'libraryGenerator-ant-');
		file_put_contents($filename, $view->render());
		return $filename;
	}

	//---------------------------------------------------------------------------------------------
	// Private static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string[] $libraryIds
	 * @param \Foomo\Flash\Vendors\Sources $sources
	 * @param \Foomo\CliCall\Compc $compc
	 */
	private static function includeLibrayIds($libraryIds, $sources, $compc)
	{
		foreach ($libraryIds as $libraryId) {
			# include library sources
			$libraryProject = $sources->getLibraryProject($libraryId);
			$compc->addSourcePaths(array($libraryProject->pathname . '/src'));
			$compc->addIncludeSources(array($libraryProject->pathname . '/src'));

			# include library dependencies
			self::includeLibrayIds($libraryProject->dependencies, $sources, $compc);

			# check for special library config
			if (null == $libraryConfig = $sources->getLibrary($libraryId)) continue;
			$compc->addSourcePaths($libraryConfig->getSources(true));
			$compc->addIncludeSources($libraryConfig->getSources(true));
			$compc->addExternalLibraryPaths($libraryConfig->getExternals(true));
		}
	}
}