<?php
/*****************************/
/*****************************/
/******                 ******/
/******      BARRES     ******/
/******                 ******/
/*****************************/
/*****************************/
require_once 'Afficher/Elements/Barres/BarreAvancement.php';
require_once 'Afficher/Elements/Barres/BarreJoueur.php';

/*****************************/
/*****************************/
/******                 ******/
/******     TABLEAUX    ******/
/******                 ******/
/*****************************/
/*****************************/
require_once 'Afficher/Elements/Tableaux/TableauResultats.php';
require_once 'Afficher/Elements/Tableaux/TableauMetagame.php';
require_once 'Afficher/Elements/Tableaux/TableauParties.php';
require_once 'Afficher/Elements/Tableaux/TableauClassement.php';

/*****************************/
/*****************************/
/******                 ******/
/******     GENERAL     ******/
/******                 ******/
/*****************************/
/*****************************/
define('__COMPAGNON__',"<img src='/Afficher/Icones/Companion.png' width='16px' title='img_compagnon'  />");
function imageCompagnon ($texte = "") {
	return "<img src='/Afficher/Icones/Companion.png' width='16px' title='$texte'  />";
}

define('__PARTENAIRES__',"<img src='/Afficher/Icones/Partner.png' width='16px' title='img_partenaire'  />");
function imagePartenaires ($place = "" , $texte = "") {
	if ($place == "principal") {
		return "<img src='/Afficher/Icones/Partner.png' width='48px' title='$texte' class='float-left mx-2' />";}
	if ($place != "adversaire") {
		return "<img src='/Afficher/Icones/Partner.png' width='16px' title='$texte' />";
	}
}

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
