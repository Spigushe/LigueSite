<?php
// Taille des morceaux de la barre
$nombreJoueurs = $helper['infos']['nbDecks'];
$nombreMatches = $nombreJoueurs - 1;
$widthMatch = round(100/$nombreMatches,2);

// Informations
$victoires = $helper[$pseudo]['victoires'];
$defaites  = $helper[$pseudo]['defaites'];
?>

<div class="progress">
	<div class="progress-bar progress-bar-striped bg-success" role="progressbar"
		style="width:<?= round($victoires*$widthMatch,2) ?>%"><?= $victoires ?></div>
	<div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
		style="width:<?= round($defaites*$widthMatch,2) ?>%"><?= $defaites ?></div>
</div>
