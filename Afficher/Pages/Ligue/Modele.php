<?php
/*****************************/
/*****************************/
/******                 ******/
/******     GENERAL     ******/
/******                 ******/
/*****************************/
/*****************************/
function afficheGeneral ($texte) {
	// De quoi est composée la command zone ?
	$contraintes = "";
	if (preg_match('/\//i',$texte)) $contraintes .= "P";
	if (preg_match('/\(/i',$texte)) $contraintes .= "C";

	// S'il n'y a qu'une carte
	if ($contraintes == "") return $texte;

	// Traitement des partenaires
	if (preg_match('/p/i',$contraintes)) {
		// Le texte à afficher
		$liste_partners = (preg_match('/c/i',$contraintes)) ? preg_split('/\(/',$texte)[0] : $texte;
		// Les deux partenaires
		$partenaires = array(
			preg_split('/\/\//i',$liste_partners)[0],
			preg_split('/\/\//i',$liste_partners)[1]
		);
		//Le retour
		$retour = __PARTENAIRES__ . $partenaires[0] . " / " . $partenaires[1];
	}

	// Traitement des compagnons
	if (preg_match('/c/i',$contraintes)) {
		$compagnon = substr(preg_split('/\(/',$texte)[1],0,strlen(preg_split('/\(/',$texte)[1])-1);
		// S'il n'y avait pas de partenaires, on va juste ajouter ce qu'il y a avant la parenthèse
		$retour = (preg_match('/p/i',$contraintes)) ? $retour : preg_split('/\(/i',$texte)[0];
		$retour .= " ( " . __COMPAGNON__ . " " . $compagnon . ")";
	}

	return $retour;
}
