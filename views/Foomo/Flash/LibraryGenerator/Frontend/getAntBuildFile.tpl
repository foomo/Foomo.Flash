<?php
/* @var $view Foomo\MVC\View */
/* @var $model Foomo\Flash\LibraryGenerator\Frontend\Model */
?>
<div class="rightBox">
	<?= $view->link('Back', 'default', array(), array('class' => 'linkButtonYellow')) ?>
</div>
<h2>Flash Library Generator</h2>
<pre><?= $model->report ?></pre>