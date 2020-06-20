<?php
function barreAvancement ($max , $played , $status) {
	ob_start(); ?>
	<div class="progress my-2" style="height: 20px;">
		<div class="progress-bar bg-info" role="progressbar" aria-valuenow="25"
			aria-valuemin="0" aria-valuemax="<?= $max ?>" style="width:<?= $status ?>%" >
		<?= $status ?> %</div>
	</div>

	<p class="text-center">
		<i><?= $played ?> matches joués sur <?= $max ?></i>
	</p>
	<?php return ob_get_clean();
}
