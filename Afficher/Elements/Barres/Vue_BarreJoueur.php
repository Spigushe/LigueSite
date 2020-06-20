<?php
function barreJoueur($victoires , $defaites , $widthMatch) {
	ob_start(); ?>
	<div class="progress">
		<div class="progress-bar progress-bar-striped bg-success" role="progressbar"
			style="width:<?= round($victoires*$widthMatch,2) ?>%"><?= $victoires ?></div>
		<div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
			style="width:<?= round($defaites*$widthMatch,2) ?>%"><?= $defaites ?></div>
	</div>
	<?php return ob_get_clean();
}
