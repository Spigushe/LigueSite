<?php
function Affichage ( $saison = "" , $ligue = "" ) {
	$infos = getInformationsDansSaisonEtLigue($saison,$ligue);
	$resultats = getResultatsDansSaisonEtLigue($saison,$ligue);

	$affichage  = "<div class='my-5'></div>";
	$affichage .= progressLigue($saison, $ligue);
	$affichage .= "<div class='my-5'></div>";
	$affichage .= "<h3 class='mt-3'>Résultats et informations</h3>";
	$affichage .= tableauJoueurs ($infos, $resultats);
	$affichage .= "<div class='my-5'></div>";
	$affichage .= "<h3 class='mt-3'>Résultat des parties</h3>";
	//$affichage .= "<p class='mb-2'><i>Il se peut qu'il faille faire défilier horizontalement le tableau pour accéder à l'ensemble des informations</i></p>";
	$affichage .= tableauResultats ($infos, $resultats);

	return $affichage;
}

function tableauJoueurs ($infos, $resultats) {
	ob_start();
	require_once('Afficher/Elements/Tableaux/TableauJoueurs.php');
	return ob_get_clean();
}

function tableauResultats ($infos, $resultats) {
	ob_start();
	require_once('Afficher/Elements/Tableaux/TableauResultats.php');
	return ob_get_clean();
}

function progressLigue ($saison , $ligue) {
	ob_start();
	require_once('Afficher/Elements/Barres/BarreAvancement.php');
	return ob_get_clean();
}
