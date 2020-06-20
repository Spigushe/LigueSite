<?php
/************
BarreAvancement
************/
function progressLigue ($helper) {
	// Définition des variables
	$max   = $helper['infos']['max'];
	$played = $helper['infos']['joues'];
	$status = round( $played / $max * 100 , 2);
	// L'élément avec affichage décalé grace à ob_start et ob_get_clean
	ob_start();
	require_once('Afficher/Elements/Ligue/BarreAvancement.php');
	return ob_get_clean();
}

/**************
TableauJoueurs
**************/
function tableauJoueurs ($helper) {
	ob_start();
	require_once('Afficher/Elements/Ligue/TableauJoueurs.php');
	return ob_get_clean();
}

function afficherBarreJoueur ($helper, $pseudo) {
	ob_start();
	include('Afficher/Elements/Ligue/BarreJoueur.php');
	return ob_get_clean();
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
		$retour = imagePartenaires() . $partenaires[0] . " / " . $partenaires[1];
	}

	// Traitement des compagnons
	if (preg_match('/c/i',$contraintes)) {
		$compagnon = substr(preg_split('/\(/',$texte)[1],0,strlen(preg_split('/\(/',$texte)[1])-1);
		// S'il n'y avait pas de partenaires, on va juste ajouter ce qu'il y a avant la parenthèse
		$retour = (preg_match('/p/i',$contraintes)) ? $retour : preg_split('/\(/i',$texte)[0];
		$retour .= " ( " . imageCompagnon() . " " . $compagnon . ")";
	}

	return $retour;
}

/**************
TableauResultats
**************/
function tableauResultats ($helper) {
	ob_start();
	require_once('Afficher/Elements/Ligue/TableauResultats.php');
	return ob_get_clean();
}

function afficheResultat ($helper, $pseudo1, $pseudo2) {
	if (isset($helper[$pseudo1]['parties'][$pseudo2])) {
		// Vainqueur de la partie
		$vainqueur = $helper[$pseudo1]['parties'][$pseudo2]['w_pseudo'];
		// Inversion pour affichage W - L du vainqueur
		if ($vainqueur != $pseudo1) {
			$pseudo2 = $pseudo1;
			$pseudo1 = $vainqueur;
		}
		// Résultat du vainqueur
		$resultat = $helper[$pseudo1]['parties'][$pseudo2]['string'];
		return "<strong>$vainqueur</strong><br><i>$resultat</i>";
	}
	return "<i>Partie à jouer</i>";
}
