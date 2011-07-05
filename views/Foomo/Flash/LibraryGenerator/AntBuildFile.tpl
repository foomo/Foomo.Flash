<?php
/* @var $view Foomo\View */
/* @var $model Foomo\Flash\Flex\CompilerConfig\Entry */
/* @var $serviceDescription Foomo\Services\ServiceDescription */
$data = array();
foreach ($model['libraryProjectIds'] as $libraryProjectId) $data[] = 'projectLibraryIds%5B%5D=' . $view->escape($libraryProjectId);
$data[] = 'name=' . $view->escape($model['name']);
$post = implode('&amp;', $data);
?>
<?= '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL ?>
<project name="<?= htmlspecialchars($_SERVER['HTTP_HOST']) ?>" basedir=".">
	<!-- generated on <?= htmlspecialchars($_SERVER['HTTP_HOST']); ?> at <?= date('Y-m-d H:i:s'); ?>-->
	<target name="updateAntFile" description="Update and download the ant file itself">
        <echo message="updating this ant file"/>
		<exec executable="/usr/bin/curl">
			<arg value="-k"/>
			<arg value="<?= Foomo\Utils::getServerUrl(false, true) . Foomo\Flash\Module::getHtdocsPath() . '/libraryGenerator.php/Foomo.Flash.LibraryGenerator/getAntBuildFile/' . $model['configId'] ?>"/>
			<arg value="--data"/>
			<arg value="<?= $post ?>"/>
			<arg value="-o"/>
			<arg value="./<?= $_SERVER['HTTP_HOST'] .'-LibraryUpdater.xml' ?>"/>
		</exec>
    </target>
<? foreach($model['libraryProjects'] as $group => $libraryProjects): ?>
	<!-- <?= $group ?> -->
<? foreach($libraryProjects as $libraryProject): ?>
	<target name="update-<?= $libraryProject->id ?>" description="Update and download the specific swc">
        <echo message="updating <?= $libraryProject->id ?>"/>
		<exec executable="/usr/bin/curl">
			<arg value="<?= Foomo\Utils::getServerUrl(false, true) . Foomo\Flash\Module::getHtdocsPath() . '/libraryGenerator.php/Foomo.Flash.LibraryGenerator/getLibrary/' . $libraryProject->id  . '/' . $model['configId'] ?>"/>
			<arg value="-o"/>
			<arg value="../libs/<?= $libraryProject->getLibraryName() . '.swc' ?>"/>
		</exec>
    </target>
<? endforeach; ?>
<? endforeach; ?>
<?if (count($model['libraryProjectIds']) > 0): ?>
	<target name="updateSwcFile" description="Update and download the custom selected swc">
        <echo message="updating the Zugspitze.swc"/>
		<exec executable="/usr/bin/curl">
			<arg value="-k"/>
			<arg value="<?= Foomo\Utils::getServerUrl(false, true) . Foomo\Flash\Module::getHtdocsPath() . '/libraryGenerator.php/Foomo.Flash.LibraryGenerator/compileLibrary/' . $model['configId'] ?>"/>
			<arg value="--data"/>
			<arg value="<?= $post ?>"/>
			<arg value="-o"/>
			<arg value="../libs/Zugspitze.swc"/>
		</exec>
    </target>
<? endif; ?>
</project>