<?php
/****** Objectif ******
Avoir un tableau global qui reprend toutes les infos d'un joueur
- Informations générales
	|- Pseudo Discord
	|- Liste des ligues et des saisons
/******   Fin    ******/

// Vérification
$joueur = (isset($parametres['joueur']) && ($parametres['joueur'] != "")) ? $parametres['joueur'] : "" ;
$helper = array(); /** VARIABLE DE STOCKAGE **/
$helper['infos'] = array(
	'pseudo'	=> ucfirst($joueur),
	'decks'		=> array(),
	'generaux'	=> array(),
	'victoires'	=> 0,
	'defaites'	=> 0,
	'matchWins'	=> 0,
	'matchLoss'	=> 0,
);
$helper['saison'] = array();

/*****************************/
/*****************************/
/******                 ******/
/****** INFOS GENERALES ******/
/******                 ******/
/*****************************/
/*****************************/
$sql = "SELECT * FROM participants WHERE pseudo LIKE :pseudo;";
// On prépare le tableau de données
$donnees = array(':pseudo'=>$helper['infos']['pseudo']);
// On exécute la requête
$requete = executerRequete($sql,$donnees)->fetch();
// Traitement du résultat
$helper['infos']['pseudo_discord'] = ""; /* INFORMATIONS NON RECUPEREE ACTUELLEMENT */
$helper['infos']['id_discord'] = $requete['id_discord'];

/*****************************/
/*****************************/
/******                 ******/
/****** DECKS ET LIGUES ******/
/******                 ******/
/*****************************/
/*****************************/
// L'objectif de cette requete est de récupérer l'ensemble des decks joués
// cela permettra de ne garder que les decks effectevement joués pour
// l'affichage
$sql = "SELECT * FROM ligues;";
// Variable de stockage temporaire
$_decks = array();
// Fonctionnement de la vairable : Clé : id // ligue ; saison
$requete = executerRequete($sql);
while ($resultat = $requete->fetch()) {
	$resultat['liste_decks'] = preg_split("/, /",$resultat['liste_decks']);
	for ($i = 0; $i < count($resultat['liste_decks']); $i++) {
		$_decks[$resultat['liste_decks'][$i]][] = array (
			'saison'	=> $resultat['num_saison'],
			'ligue'		=> $resultat['nom_ligue'],
		);
	}
}

/*****************************/
/*****************************/
/******                 ******/
/****** LISTE DES DECKS ******/
/******                 ******/
/*****************************/
/*****************************/
$sql = "SELECT * FROM decks WHERE id_discord = :id;";
// On prépare le tableau de données
$donnees = array(':id'=>$helper['infos']['id_discord']);
// On exécute la requête
$requete = executerRequete($sql,$donnees);
// Traitement du résultat
while ($resultat = $requete->fetch()) {
	// On vérifie si le deck est bien enregistré
	if (!isset($_decks[$resultat['id_deck']])) {
		// SI il n'est pas dans le helper des decks
		// ALORS on passe au deck suivant
		continue;
	}

	/* REFONTE DU HELPER */
	// Affichage par saison au lieu de id_deck

	// On ajoute l'id du deck aux decks joués
	$helper['infos']['decks'][] = $resultat['id_deck'];

	// On ajoute le général aux généraux joués
	if (!in_array($resultat['general'], $helper['infos']['generaux'])) {
		$helper['infos']['generaux'][] = $resultat['general'];
	}

	/**** CREATION DES ENTREES ****/
	// On enregistre le deck avec sa clé
	$helper['deck'][$resultat['id_deck']] = array(
		'ligues'	=> array(),
		'victoires'	=> 0,
		'defaites'	=> 0,
		'liste'		=> json_decode($resultat['liste'], TRUE),
		'general'	=> $resultat['general'],
	);

	// On enregistre le deck avec l'index 'saison'
	for ($i = 0; $i < count($_decks[$resultat['id_deck']]); $i++) {
		$saison = $_decks[$resultat['id_deck']][$i]['saison'];
		$saison -= (preg_match("/Placement/i",$_decks[$resultat['id_deck']][$i]['ligue'])) ? 1 : 0;
		$helper['saison'][$saison] = array(
			'ligue'		=> $_decks[$resultat['id_deck']][$i]['ligue'],
			'general'	=> $resultat['general'],
			'id_deck'	=> (!preg_match("/Placement/i",$_decks[$resultat['id_deck']][$i]['ligue'])) ? $resultat['id_deck'] : 0,
			'victoires'	=> 0,
			'defaites'	=> 0,
		);
	}

	/**** AJOUT DES PREMIERES INFORMATIONS ****/
	// Ligue jouée par le joueur
	for ($i = 0; $i < count($_decks[$resultat['id_deck']]); $i++) {
		// Renseignement des ligues
		$helper['infos']['ligues'][] = $_decks[$resultat['id_deck']][$i]['ligue'];
		$helper['deck'][$resultat['id_deck']]['ligue'][] = $_decks[$resultat['id_deck']][$i]['ligue'];
		// Renseignement des saisons
		$helper['infos']['saisons'][$_decks[$resultat['id_deck']][$i]['saison']][] = $resultat['id_deck'];
		$helper['deck'][$resultat['id_deck']]['saison'][] = $_decks[$resultat['id_deck']][$i]['saison'];
	}
}

/*****************************/
/*****************************/
/******                 ******/
/******    RESULTATS    ******/
/******    PAR  DECKS   ******/
/******                 ******/
/*****************************/
/*****************************/
$sql = "SELECT * FROM resultats WHERE id_deck1 = :id OR id_deck2 = :id;";
for ($i = 0; $i < count($helper['infos']['decks']); $i++) {
	$id = $helper['infos']['decks'][$i];
	// Préparation des variables de la requete
	$donnees = array( ':id' => $id );
	// Exécution de la requete
	$requete = executerRequete($sql,$donnees);
	// Traitement des résultats
	while ($resultat = $requete->fetch()) {
		// 2 cas : soit deck saisi en deck1 soit saisi en deck2
		$p_score = ($resultat['id_deck1'] == $id) ? $resultat['resultat_deck1'] : $resultat['resultat_deck2'];
		$o_score = ($resultat['id_deck1'] == $id) ? $resultat['resultat_deck2'] : $resultat['resultat_deck1'];
		// Comtpage
		$helper['deck'][$id]['victoires'] += ($p_score > $o_score) ? 1 : 0;
		$helper['deck'][$id]['defaites']  += ($p_score > $o_score) ? 0 : 1;
		// Infos générales
		$helper['infos']['victoires'] += $p_score;
		$helper['infos']['defaites']  += $o_score;
		$helper['infos']['matchWins']  += ($p_score > $o_score) ? 1 : 0;
		$helper['infos']['matchLoss']  += ($p_score > $o_score) ? 0 : 1;
	}
}
