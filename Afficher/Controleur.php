<?php

function getContenu ($params)
{
	// Affichage d'une ligue
	if (isset($params['saison']) && isset($params['ligue'])) {
		$ligue = stripslashes($params['ligue']);

		// Affichage
		if (preg_match("/Placement/", $ligue)) {
			// Résumé placements
			require_once 'Afficher/Pages/Placement/Controleur.php';
		} else if (preg_match("/Playoff/", $ligue)) {
			// Résumé playoffs
			require_once 'Afficher/Pages/Playoff/Controleur.php';
		} else {
			// Résumé Ligue
			require_once 'Afficher/Pages/Ligue/Controleur.php';
		}
	}

	// Affichage d'un joueur
	else if (isset($params['joueur'])) {
		require_once "Afficher/Pages/Joueur/Controleur.php";
	}

	// Affichage d'une saison
	else {
		// Page d'accueil
		require_once 'Afficher/Pages/Saison/Controleur.php';
	}
	return Affichage($helper);
}

require_once 'Afficher/Vue.php';
