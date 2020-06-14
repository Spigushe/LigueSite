<?php
require_once('Afficher/Elements/Barres/Modele.php');
$nombreJoueurs = count(getTableDecks());
$nombreMatches = $nombreJoueurs - 1;
$widthMatch = round(100/$nombreMatches,2);
?>

<div class="progress">
	<?php
	$infos[$rang]['victoires'] = 0;
	$infos[$rang]['defaites']  = 0;
	$infos[$rang]['nbMatches'] = 0;
	for ($i = 0; $i < $nombreJoueurs; $i++) {
		if ($i != $rang) {
			$score = getScore($infos[$rang]['id_deck'],$infos[$i]['id_deck']);
			if ($score['victoires'] > $score['defaites']) {
				$infos[$rang]['victoires'] += 1;
				$infos[$rang]['nbMatches'] += 1;
			} else if ($score['defaites'] > $score['victoires']) {
				$infos[$rang]['defaites'] += 1;
				$infos[$rang]['nbMatches'] += 1;
			}
		}
	}
	$infos[$rang]['nbMatches'] = max($infos[$rang]['nbMatches'],1);//Pour éviter la DIV%0
	$infos[$rang]['nbMatches'] = ($infos[$rang]['victoires'] + $infos[$rang]['defaites']) / $infos[$rang]['nbMatches'];
	?>
	<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width:<?= round($infos[$rang]['victoires']*$widthMatch/$infos[$rang]['nbMatches'],2) ?>%"><?= $infos[$rang]['victoires'] ?></div>
	<div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width:<?= round($infos[$rang]['defaites']*$widthMatch/$infos[$rang]['nbMatches'],2) ?>%"><?= $infos[$rang]['defaites'] ?></div>
</div>
