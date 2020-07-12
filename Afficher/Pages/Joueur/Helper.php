<?php
/****** Objectif ******
Avoir un tableau global qui reprend toutes les infos d'un joueur
- Informations générales
	|- Pseudo Discord
	|- Liste des ligues et des saisons
/******   Fin    ******/

$helper = array(); /** VARIABLE DE STOCKAGE **/
$helper['infos'] = array();
$helper['infos']['decks'] = array();
$helper['infos']['ligues'] = array();

/*****************************/
/*****************************/
/******                 ******/
/****** INFOS GENERALES ******/
/******                 ******/
/*****************************/
/*****************************/
$sql = "SELECT * FROM participants WHERE pseudo = :pseudo;";
// On prépare le tableau de données
$donnees = array(':pseudo'=>$_GET['joueur']);
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

	// id du deck
	$helper['infos']['decks'][] = $resultat['id_deck'];
	// infos du deck
	$helper['deck'][$resultat['id_deck']] = array(
		'ligue'		=> array(),
		'victoires'	=> 0,
		'defaites'	=> 0,
		'liste'		=> json_decode($resultat['liste']),
		'general'	=> $resultat['general'],
	);

	// Ligue jouée par le joueur
	for ($i = 0; $i < count($_decks[$resultat['id_deck']]); $i++) {
		if (preg_match("/Playoff/", $_decks[$resultat['id_deck']][$i]['ligue'])) {
			// Ne pas afficher les playoffs dans les ligues jouées
			continue;
		}
		$helper['infos']['ligues'][] = $_decks[$resultat['id_deck']][$i]['ligue'] . " S" . $_decks[$resultat['id_deck']][$i]['saison'];
		$helper['deck'][$resultat['id_deck']]['ligue'][] = $_decks[$resultat['id_deck']][$i]['ligue'] . " S" . $_decks[$resultat['id_deck']][$i]['saison'];
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
	}
}
