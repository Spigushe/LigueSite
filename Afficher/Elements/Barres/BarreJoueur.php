<?php
require_once "Afficher/Elements/Barres/Vue_BarreJoueur.php";

function afficherBarreJoueur ($helper, $pseudo) {
	// Taille des morceaux de la barre
	$nombreJoueurs = $helper['infos']['nbDecks'];
	$nombreMatches = $nombreJoueurs - 1;
	$widthMatch = round(100/$nombreMatches,2);

	// Informations
	$victoires = $helper[$pseudo]['victoires'];
	$defaites  = $helper[$pseudo]['defaites'];
	// L'élément avec affichage décalé grace à ob_start et ob_get_clean
	return barreJoueur($victoires , $defaites , $widthMatch);
}

?>
