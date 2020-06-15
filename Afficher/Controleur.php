<?php

function getContenu () {
	if (isset($_GET['saison']) && isset($_GET['ligue'])) {
		// Affichage
		if ($_GET['ligue'] == 'Placement') {
			// Résumé placements
			//require_once('Afficher/Elements/Placement.php');
		} else if ($_GET['ligue'] == 'Playoffs') {
			// Résumé playoffs
			//require_once('Afficher/Elements/Playoffs.php');
		} else {
			// Résumé Ligue
			require_once('Afficher/Elements/Ligue.php');
		}
	}
	// Page d'accueil
	require_once('Afficher/Elements/Saison.php'); // Page d'accueil
	return Affichage($helper);
}

require_once('Afficher/Vue.php');
