<?php

function getContenu ()
{
	// Affichage d'une ligue
	if (isset($_GET['saison']) && isset($_GET['ligue']))
	{
		$ligue = stripslashes($_GET['ligue']);

		// Affichage
		if (preg_match("/Placement/", $ligue))
		{
			// Résumé placements
			require_once 'Afficher/Pages/Placement/Controleur.php';
		}
		else if (preg_match("/Playoff/", $ligue))
		{
			// Résumé playoffs
			require_once 'Afficher/Pages/Playoff/Controleur.php';
		}
		else
		{
			// Résumé Ligue
			require_once 'Afficher/Pages/Ligue/Controleur.php';
		}
	}

	// Affichage d'un joueur
	else if (isset($_GET['joueur']))
	{
		require_once "Afficher/Pages/Joueur/Controleur.php";
	}

	// Affichage d'une saison
	else
	{
		// Page d'accueil
		require_once 'Afficher/Pages/Saison/Controleur.php';
	}
	return Affichage($helper);
}

require_once 'Afficher/Vue.php';
