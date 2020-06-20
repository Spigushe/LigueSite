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

/*****************************/
/*****************************/
/******                 ******/
/****** LISTE DES POOLS ******/
/******                 ******/
/*****************************/
/*****************************/
$sql = "SELECT liste_decks FROM ligues
		WHERE num_saison = :s AND nom_ligue LIKE '%Placement%';";
// On prépare les variables de base
$helper['infos']['saison'] = $_GET['saison'];
$helper['infos']['ligue']  = preg_split("/-/",$_GET['ligue'])[0];
// On prépare le tableau de données
$donnees = array(
	':s' => $helper['infos']['saison'],
);
// On exécute la requête
$requete = executerRequete($sql,$donnees);
$groupe = 0;
while ($resultat = $requete->fetch()) {
	$groupe += 1;
	$_liste = preg_split("/, /",$resultat['liste_decks']);
	$_nbDecks = count($_liste);
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
		saison = :s AND ligue = :l;";
// On ajoute la saison aux données
$donnees[':l'] = $helper['infos']['ligue'];
// On parcourt les groupes
for ($i = 1; $i <= count($helper['groupe']); $i++) {
	// On parcourt la liste des decks
	foreach ($helper['groupe'][$i]['decks'] as $key => $value) {
		// On dit sur quel deck on fait la recherche
		$donnees[':id'] = $value;
		$requete = executerRequete($sql,$donnees);
		while ($resultat = $requete->fetch()) {
			$helper['groupe'][$i]['matches'] += 1;
		}
	}
	// On effectue les derniers calculs
	$helper['groupe'][$i]['avancement'] = round($helper['groupe'][$i]['matches'] / $helper['groupe'][$i]['maxMatches'] * 100 , 2);
}
