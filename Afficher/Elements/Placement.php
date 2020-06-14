<?php
function Affichage ( $saison = "" , $ligue = "" ) {
	$infos = getInformationsDansSaisonEtLigue($saison,$ligue);
	$resultats = getResultatsDansSaisonEtLigue($saison,$ligue);
	
	$affichage = "";
	$affichage .= "<h3 class='mt-3'>Détail du metagame</h3>";
	$affichage .= tableauMetagame ($infos, $resultats);
	$affichage .= "<div class='my-5'></div>";
	$affichage .= "<h3 class='mt-3'>Résumé des parties</h3>";
	$affichage .= tableauParties ($infos, $resultats);
	$affichage .= "<div class='my-5'></div>";
	
	return $affichage;
}

function tableauMetagame ($infos, $resultats) {
	ob_start();
	require_once('Afficher/Elements/Tableaux/TableauMetagame.php');
	return ob_get_clean();
}

function tableauParties ($infos, $resultats) {
	ob_start();
	require_once('Afficher/Elements/Tableaux/TableauParties.php');
	return ob_get_clean();
}
