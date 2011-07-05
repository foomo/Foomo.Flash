<?php
/* @var $view Foomo\MVC\View */
/* @var $model Foomo\Flash\LibraryGenerator\Frontend\Model */
/* @var $libraryProject Foomo\Flash\Vendor\Sources\Project */
?>
<h2>Flash Library Generator</h2>

Select a configuration entry: <select class="flexConfigEntryList">
<? foreach(\Foomo\Flash\Module::getCompilerConfig()->entries as $entryId => $entry): ?>
	<option value="<?= $entryId ?>"><?= $entry['name'] ?></option>
<? endforeach; ?>
</select>

<br><br>

Select a configuration preset: <select class="libraryConfigPresetList">
	<option value="">User defined</option>
<? foreach($model->presets as $preset): ?>
	<option value="<?= implode(',', $preset->projectLibraryIds) ?>"><?= $preset->name ?></option>
<? endforeach; ?>
</select>

<form id="flash-library-form" method="POST" actionDownloadSwc="<?= $view->url('getCustomLibrary') ?>"  actionDownloadAnt="<?= $view->url('getAntBuildFile') ?>">
	<table>
		<thead>
			<tr>
				<td>Name</td>
				<td>Description</td>
				<td>Dependencies</td>
				<td>Version</td>
				<td></td>
				<td></td>
			</tr>
		</thead>
		<tbody>
<? foreach($model->libraryProjects as $group => $libraryProjects): ?>
			<tr>
				<td colspan="6"><h2><?= $group ?></h2></td>
			</tr>
<? foreach($libraryProjects as $libraryProject): ?>
			<tr>
				<td><?= $view->escape($libraryProject->name) ?></td>
				<td><?= $view->escape($libraryProject->description) ?></td>
				<td><?= $view->escape(implode(', ', $libraryProject->dependencies)) ?></td>
				<td><?= $view->escape($libraryProject->version) ?></td>
				<td><?= $view->link('download', 'getLibrary', array($libraryProject->id), array('class' => 'getLibraryLink')) ?></td>
				<td><input class="libraryProject" value="<?= $libraryProject->id ?>" name="projectLibraryIds[]" type="checkbox" dependencies="<?= implode(',', $libraryProject->dependencies) ?>"></input></td>
			</tr>
<? endforeach; ?>
<? endforeach; ?>
		</tbody>
	</table>

	<p>
		<input type="text" name="name" value="Name-version"></input>
		<input id="download-swc-button" type="submit" value="Download SWC">
		<input id="download-ant-button" type="submit" value="Download ANT File">
	</p>

</form>
