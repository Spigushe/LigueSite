<?php
require_once('Afficher/Elements/Tableaux/Vue_TableauResultats.php');

function AfficherTableauResultats ($helper) {
	$retour  = "<h3 class='mt-3'>Résultat des parties</h3>";
	$retour .= "<p class='mb-2'><i>You might have to scroll horizontally to access everything</i></p>";
	$retour .=  tableauResultats($helper);
	$retour .= "<div class='my-5'></div>";

	return $retour;
}

function afficheResultat ($helper, $pseudo1, $pseudo2) {
	if (isset($helper[$pseudo1]['parties'][$pseudo2])) {
		// Vainqueur de la partie
		$vainqueur = $helper[$pseudo1]['parties'][$pseudo2]['w_pseudo'];
		// Inversion pour affichage W - L du vainqueur
		if ($vainqueur != $pseudo1) {
			$pseudo2 = $pseudo1;
			$pseudo1 = $vainqueur;
		}
		// Résultat du vainqueur
		$resultat = $helper[$pseudo1]['parties'][$pseudo2]['string'];
		return "<strong>$vainqueur</strong><br><i>$resultat</i>";
	}
	return "<i>Partie à jouer</i>";
}
