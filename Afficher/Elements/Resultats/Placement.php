<?php
/****** Objectif ******
Avoir un tableau global qui reprend toutes les infos d'une ligue et d'une saison
- Informations générales
	|- Saison
- Liste des groupes
	|- Liste des decks
	|- Nombre de parties
	|- Matches joués
	|- Avancement
 ******   Fin    ******/

$helper = array(); /** VARIABLE DE STOCKAGE **/
$ligue = $_GET['ligue']; /** FIXING SQL QUERY **/

/*****************************/
/*****************************/
/******                 ******/
/****** LISTE DES POOLS ******/
/******                 ******/
/*****************************/
/*****************************/
$sql = "SELECT * FROM ligues
		WHERE num_saison = :s AND nom_ligue LIKE '%$ligue%';";
// On prépare les variables de base
$helper['infos']['saison'] = $_GET['saison'];
$helper['infos']['ligue']  = $ligue;
$helper['infos']['groupes'] = array();
$helper['groupe'] = array();
// On prépare le tableau de données
$donnees = array(
	':s' => $helper['infos']['saison'],
);
// On exécute la requête
$requete = executerRequete($sql,$donnees);
while ($resultat = $requete->fetch()) {
	$groupe = $resultat['nom_ligue'];
	$_liste = preg_split("/, /",$resultat['liste_decks']);
	$_nbDecks = count($_liste);
	// Ajout du groupe dans les infos
	$helper['infos']['groupes'][] = $groupe;
	// Ajout des détails du groupe
	$helper['groupe'][$groupe]['liste'] = $resultat;
	$helper['groupe'][$groupe]['decks'] = $_liste;
	$helper['groupe'][$groupe]['nbDecks'] = $_nbDecks;
	$helper['groupe'][$groupe]['maxMatches'] = $_nbDecks * ($_nbDecks - 1) / 2;
	$helper['groupe'][$groupe]['matches'] = 0;
}

/*****************************/
/*****************************/
/******                 ******/
/******  INFOS PARTIES  ******/
/******                 ******/
/*****************************/
/*****************************/
$sql = "SELECT * FROM resultats r
		JOIN decks d ON d.id_deck = r.id_deck1
		WHERE r.id_deck1 = :id AND
		saison = :s AND ligue LIKE '%$ligue%';";
// On parcourt les groupes
for ($i = 0; $i < count($helper['infos']['groupes']); $i++) {
	$groupe = $helper['infos']['groupes'][$i];
	// On parcourt la liste des decks
	foreach ($helper['groupe'][$groupe]['decks'] as $key => $value) {
		// On dit sur quel deck on fait la recherche
		$donnees[':id'] = $value;
		$requete = executerRequete($sql,$donnees);
		while ($resultat = $requete->fetch()) {
			$helper['groupe'][$groupe]['matches'] += 1;
		}
	}
	// On effectue les derniers calculs
	$helper['groupe'][$groupe]['avancement'] =
		round($helper['groupe'][$groupe]['matches'] / $helper['groupe'][$groupe]['maxMatches'] * 100 , 2);
}
