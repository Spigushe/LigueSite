<?php require_once('Afficher/Elements/Barres/Modele.php'); ?>
<div class="progress my-2" style="height: 20px;">
	<div class="progress-bar bg-info" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="<?= getMaxMatches() ?>" style="width:<?= getAvancement() ?>%" >
	<?= round(getMatchesPlayed()/getMaxMatches()*100,2) ?> %</div>
</div>

<p class="text-center">
	<i><?= getMatchesPlayed() ?> matches joués sur <?= getMaxMatches() ?></i>
</p>
