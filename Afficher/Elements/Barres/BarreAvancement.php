<?php
require_once "Afficher/Elements/Barres/Vue_BarreAvancement.php";

function progressLigue ($ligue) {
	// Définition des variables
	$max   = $ligue['infos']['max'];
	$played = $ligue['infos']['joues'];
	$status = round( $played / $max * 100 , 2);
	// L'élément avec affichage décalé grace à ob_start et ob_get_clean
	$retour  = "<div class='my-5'></div>";
	$retour .= barreAvancement ($max , $played , $status);
	$retour .= "<div class='my-5'></div>";

	return $retour;
}


function afficheGroupe ($groupe,$infos) {
	// Définition des variables
	$max    = $infos['maxMatches'];
	$played = $infos['matches'];
	$status = $infos['avancement'];
	// L'élément avec affichage décalé grace à ob_start et ob_get_clean
	ob_start(); ?>
	<div>
		<p class='h3 text-decoration-none'>
			<a href="/Saison-<?= __SAISON__ ?>/<?= $groupe ?>" class="text-reset">
				Groupe <?= $groupe ?>
			</a>
		</p>
		<?= barreAvancement ($max , $played , $status) ?>
	</div>
	<div class='my-5'></div>
	<?php $retour = ob_get_clean();
	return $retour;
}
