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
	// id du deck
	$helper['infos']['decks'][] = $resultat['id_deck'];
	// infos du deck
	$helper['deck'][$resultat['id_deck']] = array(
		'ligue'		=> "",
		'victoires'	=> 0,
		'defaites'	=> 0,
		'liste'		=> json_decode($resultat['liste']),
		'general'	=> $resultat['general'],
	);
}


echo "<h1>Helper</h1>";
print_r($helper);
