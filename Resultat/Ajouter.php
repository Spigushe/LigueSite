<?php

function nouveauResultat ($informations)
{
	// Préparation des infos des joueurs
	$joueur1 = array (
		'pseudo' => $informations['joueur1'],
		'resultat' => $informations['resultat1']
	);
	$joueur2 = array (
		'pseudo' => $informations['joueur2'],
		'resultat' => $informations['resultat2']
	);

	// Récupération de l'id du joueur 1
	$joueur1['id'] = joueurParPseudo($joueur1['pseudo']);
	// Récupération de l'id du joueur 2
	$joueur2['id'] = joueurParPseudo($joueur2['pseudo']);
	// Tests
	if (isset($_SESSION['dicoErreurs'][$joueur1['id']])) {
		return $_SESSION['dicoErreurs'][$joueur1['id']];
	}
	if (isset($_SESSION['dicoErreurs'][$joueur2['id']])) {
		return $_SESSION['dicoErreurs'][$joueur2['id']];
	}

	// Récupération de la ligue du joueur 1
	$joueur1['ligue'] = getLigue($joueur1['id']);
	// Récupération de la ligue du joueur 2
	$joueur2['ligue'] = getLigue($joueur2['id']);
	// Tests
	if (isset($_SESSION['dicoErreurs'][$joueur1['ligue']])) {
		return $_SESSION['dicoErreurs'][$joueur1['ligue']];
	}
	if (isset($_SESSION['dicoErreurs'][$joueur2['ligue']])) {
		return $_SESSION['dicoErreurs'][$joueur2['ligue']];
	}
	// Jouent-ils dans la même ligue ?
	if ($joueur2['ligue'] != $joueur2['ligue']){
		return $_SESSION['dicoErreurs']['e106'];
	}

	// Vérification de la saison
	$joueur1['saison'] = __SAISON__;
	if (preg_match("/Placement/i",$joueur1['ligue'])) {
		$joueur1['saison'] += 1;
	}
	$joueur2['saison'] = $joueur1['saison'];

	// Récupération du deck du joueur 1
	$joueur1['deck'] = deckParJoueur($joueur1['id']);
	// Récupération du deck du joueur 2
	$joueur2['deck'] = deckParJoueur($joueur2['id']);
	// Tests
	if (isset($_SESSION['dicoErreurs'][$joueur1['deck']])) {
		return $_SESSION['dicoErreurs'][$joueur1['deck']];
	}
	if (isset($_SESSION['dicoErreurs'][$joueur2['deck']])) {
		return $_SESSION['dicoErreurs'][$joueur2['deck']];
	}

	// Combien y a-t-il de résultats saisis pour cette paire ?
	$nb_match = max(0,nombreMatches($joueur1, $joueur2));
	if ($nb_match >= __MAX_MATCHES__) {
		return "Erreur : Résultat déjà saisi";
	}

	return ajouterResultat ($joueur1, $joueur2);
}
