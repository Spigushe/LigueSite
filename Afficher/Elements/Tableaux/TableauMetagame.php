<?php
require_once("Afficher/Elements/Tableaux/Vue_TableauMetagame.php");

function afficherTableauMetagame ($helper) {
	// Transposition du helper
	sort($helper['infos']['pseudo']);
	$lignes = array();
	for ($i = 0; $i < count($helper['infos']['pseudo']); $i++) {
		$cle = $helper['infos']['pseudo'][$i];
		if (!in_array($helper[$cle]['general'], $lignes)) {
			$lignes[$helper[$cle]['general']]['general'] = afficheGeneralMetagame($helper[$cle]['general']);
			$lignes[$helper[$cle]['general']]['joueurs'][] = $cle;
			$lignes[$helper[$cle]['general']][$cle]['parties'] = $helper[$cle]['victoires'] . " - " . $helper[$cle]['defaites'];
			$lignes[$helper[$cle]['general']][$cle]['ligue'] = min(3,$helper[$cle]['victoires']);
		}
	}
	// L'élément avec affichage décalé grace à ob_start et ob_get_clean
	return tableauMetagame($lignes);
}
