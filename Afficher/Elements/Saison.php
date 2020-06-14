<?php
function ResumeLigue ($saison) {
	$ligues = LiguesEnCours($saison);

	$barresAvancement = "";
	for ($i = 0; $i < count($ligues); $i++) {
		// On redéfinit les variables globales
		$_GET['saison'] = $saison;
		$_GET['ligue']  = $ligues[$i];

		$barresAvancement .= "<p class='h3'>Ligue " . ucfirst($ligues[$i]) . "</p>";
		ob_start();
		include('Afficher/Elements/Barres/BarreAvancement.php');
		$barresAvancement .= ob_get_clean();

		unset($_GET['ligue']);
	}

	return $barresAvancement;
}

function LiguesEnCours ($saison) {
	$sql = 	"SELECT " . //
				"nom_ligue " . //
			"FROM " . //
				"ligues " . //
			"WHERE " . //
				"num_saison = '$saison';";
	$requete = executerRequete($sql);

	$retour = array();
	while ($resultat = $requete->fetch()) {
		if ($resultat['nom_ligue'] != "Placement") {
			$retour[] = $resultat['nom_ligue'];
		}
	}

	return $retour;
}
