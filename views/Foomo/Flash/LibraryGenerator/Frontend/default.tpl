<?php
/* @var $view Foomo\MVC\View */
/* @var $model Foomo\Flash\LibraryGenerator\Frontend\Model */
/* @var $libraryProject Foomo\Flash\Vendor\Sources\Project */
?>
<h2>Flash Library Generator</h2>

<div class="greyBox">

	<div class="formBox">
		<div class="formTitle">Select a configuration entry</div>
		<select class="flexConfigEntryList">
		<? foreach(\Foomo\Flash\Module::getCompilerConfig()->entries as $entryId => $entry): ?>
			<option value="<?= $entryId ?>"><?= $entry['name'] ?></option>
		<? endforeach; ?>
		</select>
	</div>
	<div class="formBox">
		<div class="formTitle">Select a configuration preset</div>
		<select class="libraryConfigPresetList">
			<option value="">User defined</option>
		<? foreach($model->presets as $preset): ?>
			<option value="<?= implode(',', $preset->projectLibraryIds) ?>"><?= $preset->name ?></option>
		<? endforeach; ?>
		</select>
	</div>

	<form id="flash-library-form" method="POST" actionDownloadSwc="<?= $view->url('getCustomLibrary') ?>"  actionDownloadAnt="<?= $view->url('getAntBuildFile') ?>">
		<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>Description</th>
					<th>Dependencies</th>
					<th>Version</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
	<? foreach($model->libraryProjects as $group => $libraryProjects): ?>
				<tr>
					<td colspan="6" class="tableInnerHead"><h3><?= $group ?></h3></td>
				</tr>
	<? foreach($libraryProjects as $libraryProject): ?>
				<tr>
					<td><?= $view->escape($libraryProject->name) ?></td>
					<td><?= $view->escape($libraryProject->description) ?></td>
					<td><?= $view->escape(implode(', ', $libraryProject->dependencies)) ?></td>
					<td><?= $view->escape($libraryProject->version) ?></td>
					<td><?= $view->link('download', 'getLibrary', array($libraryProject->id), array('class' => 'getLibraryLink linkButtonYellow')) ?></td>
					<td><input class="libraryProject" value="<?= $libraryProject->id ?>" name="projectLibraryIds[]" type="checkbox" dependencies="<?= implode(',', $libraryProject->dependencies) ?>"></input></td>
				</tr>
	<? endforeach; ?>
	<? endforeach; ?>
			</tbody>
		</table>

		<div class="formBox">
			<input type="text" name="name" value="Name-version"></input>
			<input id="download-swc-button" type="submit" value="Download SWC" class="submitButton">
			<input id="download-ant-button" type="submit" value="Download ANT File" class="submitButton">
		</div>

	</form>
</div>