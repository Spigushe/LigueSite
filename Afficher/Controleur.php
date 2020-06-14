<?php
// Helper
if (isset($_GET['saison']) && isset($_GET['ligue'])) {
	require_once("Afficher/Resultats.php");
} else {
	require_once("Afficher/Resultats_globaux.php");
}

function getContenu ($resultats) {
	if (isset($_GET['saison']) && isset($_GET['ligue'])) {
		if ($_GET['ligue'] == 'Placement') { // Résumé placements
			require_once('Afficher/Elements/Placement.php');
		} else if ($_GET['ligue'] == 'Playoffs') { // Résumé playoffs
			require_once('Afficher/Elements/Playoffs.php');
		} else require_once('Afficher/Elements/Ligue.php'); // Résumé Ligue
	}
	require_once('Afficher/Elements/Saison.php'); // Page d'accueil
	return Affichage($resultats);
}

require_once('Afficher/Vue.php');
