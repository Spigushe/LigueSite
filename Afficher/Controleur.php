<?php
function getContenu () {
	if (isset($_GET['saison']) && isset($_GET['ligue'])) {
		if ($_GET['ligue'] == 'Placement') {
			require_once('Afficher/Elements/Placement.php');
		} else if ($_GET['ligue'] == 'Playoffs') {
			require_once('Afficher/Elements/Playoffs.php');
		} else require_once('Afficher/Elements/Ligue.php');
		return Affichage($_GET['saison'],$_GET['ligue']);
	}

	// Page d'accueil
	require_once('Afficher/Elements/Saison.php');
	return ResumeLigue(SaisonEnCours());

}

require_once('Afficher/Vue.php');
