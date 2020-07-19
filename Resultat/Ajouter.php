<?php

function nouveauResultat ($informations)
{
	// Préparation des infos des joueurs
	$joueur1 = array (
		'pseudo' => $informations['joueur1'],
		'resultat' => $informations['resultat1'],
		'win' => ($informations['resultat1'] > $informations['resultat2']) ? 1 : 0,
	);
	$joueur2 = array (
		'pseudo' => $informations['joueur2'],
		'resultat' => $informations['resultat2'],
		'win' => ($informations['resultat2'] > $informations['resultat1']) ? 1 : 0,
	);

	// Récupération des infos de la table 'participants'
	if (infosParticipant($joueur1) || infosParticipant($joueur2)) {
		return __ERREURS__['002'];
	}
	// Jouent-ils dans la même ligue ?
	if ($joueur1['ligue'] != $joueur2['ligue']){
		return __ERREURS__['e106'];
	}

	// Vérification de la saison
	$joueur1['saison'] = __SAISON__;
	$joueur1['saison'] +=  (preg_match("/Placement/i",$joueur1['ligue'])) ? 1 : 0;
	$joueur2['saison'] = $joueur1['saison'];

	// Récupération du deck du joueur 1
	$joueur1['deck'] = deckParJoueur($joueur1['id']);
	// Récupération du deck du joueur 2
	$joueur2['deck'] = deckParJoueur($joueur2['id']);
	// Tests
	if (isset(__ERREURS__[$joueur1['deck']]) ||isset(__ERREURS__[$joueur2['deck']])) {
		return __ERREURS__['e105'];
	}

	// Combien y a-t-il de résultats saisis pour cette paire ?
	if (max(0,nombreMatches($joueur1, $joueur2)) >= __MAX_MATCHES__) {
		return __ERREURS__['e109'];
	}

	// Calcul du changement d'elo
	// Calcul de p(D)
	$probaWinJoueur1 = 1 / (1 + pow(10, ($joueur1['elo'] - $joueur2['elo']) / -400));
	$probaWinJoueur2 = 1 - $probaWinJoueur1;
	// Calcul du coefficient
	$coef = (($joueur1['resultat'] + $joueur2['resultat']) == 3) ? 25 : 50;
	$coef += preg_match("/Placement/i",$joueur1['ligue']) ? 25 : 0;
	// Elo bonus pour accéler la différenciation des premiers matches
	$joueur1['elo'] += round($coef * ($joueur1['win'] - $probaWinJoueur1));
	$joueur2['elo'] += round($coef * ($joueur2['win'] - $probaWinJoueur2));

	return ajouterResultat ($joueur1, $joueur2);
}
