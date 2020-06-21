<?php

function getContenu ()
{
	if (isset($_GET['saison']) && isset($_GET['ligue']))
	{
		// Affichage
		if (preg_match("/Placement/", $_GET['ligue']))
		{
			// Résumé placements
			require_once('Afficher/Elements/Placement/Controleur.php');
		}
		else if (preg_match("/Playoff/", $_GET['ligue']))
		{
			// Résumé playoffs
			//require_once('Afficher/Elements/Playoffs.php');
		}
		else
		{
			// Résumé Ligue
			require_once('Afficher/Elements/Ligue/Controleur.php');
		}
	}
	else
	{
		// Page d'accueil
		require_once('Afficher/Elements/Saison.php');
	}
	return Affichage($helper);
}

require_once('Afficher/Vue.php');
