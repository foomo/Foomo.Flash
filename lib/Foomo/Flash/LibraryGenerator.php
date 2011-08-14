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

		$sources = Vendor::getSources();
		foreach ($libraryProjectIds as $libraryProjectId) {
			# include library sources
			$libraryProject = $sources->getLibraryProject($libraryProjectId);
			$compc->addSourcePaths(array($libraryProject->pathname . '/src'));
			$compc->addIncludeSources(array($libraryProject->pathname . '/src'));

			# include library dependencies
			foreach ($libraryProject->dependencies as $depedencyLibraryProjectId) {
				$dependencyLibraryProject = $sources->getLibraryProject($depedencyLibraryProjectId);
				$compc->addSourcePaths(array($dependencyLibraryProject->pathname . '/src'));
				$compc->addIncludeSources(array($dependencyLibraryProject->pathname . '/src'));

				# check for special library config
				if (null == $dependencyLibraryConfig = $sources->getLibrary($depedencyLibraryProjectId)) continue;
				$compc->addSourcePaths($dependencyLibraryConfig->getSources(true));
				$compc->addIncludeSources($dependencyLibraryConfig->getSources(true));
				$compc->addExternalLibraryPaths($dependencyLibraryConfig->getExternals(true));
			}

			# check for special library config
			if (null == $libraryConfig = $sources->getLibrary($libraryProjectId)) continue;
			$compc->addSourcePaths($libraryConfig->getSources(true));
			$compc->addIncludeSources($libraryConfig->getSources(true));
			$compc->addExternalLibraryPaths($libraryConfig->getExternals(true));
		}

		$fileName = tempnam(\Foomo\Flash\Module::getTempDir(), 'libraryGenerator-swc-');
		$report .= $compc->compileSwc($fileName)->report;

		if ($compc->exitStatus !== 0 || !file_exists($fileName)) {
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

		return $fileName;
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
		$fileName = tempnam(\Foomo\Flash\Module::getTempDir(), 'libraryGenerator-ant-');
		file_put_contents($fileName, $view->render());
		return $fileName;
	}
}