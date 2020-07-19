<?php
/*****************************/
/*****************************/
/******                 ******/
/******    NOM LIGUE    ******/
/******                 ******/
/*****************************/
/*****************************/
function getLigue($int) {
	$ligues  = array();
	$ligues[] = "Bois / Wood";
	$ligues[] = "Bronze / Bronze";
	$ligues[] = "Argent / Silver";
	$ligues[] = "Or / Gold";
	$ligues[] = "Platine / Platinium";
	return $ligues[$int];
}

/*****************************/
/*****************************/
/******                 ******/
/****** GENERALMETAGAME ******/
/******                 ******/
/*****************************/
/*****************************/
function afficheGeneralMetagame ($texte) {
	// De quoi est composée la command zone ?
	$contraintes = "";
	if (preg_match('/\//i',$texte)) $contraintes .= "P";
	if (preg_match('/\(/i',$texte)) $contraintes .= "C";
	// S'il n'y a qu'une carte
	if ($contraintes == "") return $texte;

	$retour = "";
	// Traitement des partenaires
	if (preg_match('/p/i',$contraintes)) {
		$liste_partners = (preg_match('/c/i',$contraintes)) ? preg_split('/\(/',$texte)[0] : $texte;
		$partenaires = array(preg_split('/\/\//i',$liste_partners)[0],preg_split('/\/\//i',$liste_partners)[1]);
		$retour .= imagePartenaires("principal") . "<div>" . $partenaires[0] . "<br />" . $partenaires[1] . "</div>";
	}

	// Traitement des compagnons
	if (preg_match('/c/i',$contraintes)) {
		$compagnon = substr(preg_split('/\(/',$texte)[1],0,strlen(preg_split('/\(/',$texte)[1])-1);
		// S'il y a en plus des partenaires
		if (preg_match('/p/i',$contraintes)) {
			return $retour . "<div>" . __COMPAGNON__ . $compagnon . "</div>";
		}
		// S'il n'y a pas de partenaires
		return $retour . preg_split('/\(/i',$texte)[0] . "<div>" . __COMPAGNON__ . $compagnon . "</div>";
	}

	return $retour;
}
