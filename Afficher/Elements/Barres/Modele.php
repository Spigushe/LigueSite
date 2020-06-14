<?php
function getListeDecks () {
	$saison = $_GET['saison'];
	$ligue  = $_GET['ligue'];

	$sql =	"SELECT * " . //
			"FROM ligues " . //
			"WHERE " . //
				"num_saison = '$saison' " . //
			"AND " . //
				"nom_ligue LIKE '%$ligue%';";

	// Liste des decks
	return executerRequete($sql)->fetch()['liste_decks'];
}

function getTableDecks () {
	return preg_split("/, /",getListeDecks());
}

function isMatchPlayed ($id1, $id2) {
	if (!isset($_GET['saison']) && ($_GET['saison'] != "")) {
		$resultats = "resultats";
	} else if (SaisonEnCours() != $_GET['saison']) {
		$resultats = "resultats_saison".$_GET['saison'];
	} else {
		$resultats = "resultats";
	}

	$sql =	"SELECT " . //
				"COUNT(id_resultat) " . //
			"FROM " . //
				"$resultats " . //
			"WHERE " . //
				"(id_deck1 = '$id1' AND id_deck2 = '$id2') " . //
				"OR " . //
				"(id_deck1 = '$id2' AND id_deck2 = '$id1') " . //
			"ORDER BY " . //
				"$resultats.id_resultat " . //
			"DESC;";

	return executerRequete($sql)->fetchColumn();
}

function getMatchesPlayed () {
	$tableDecks = getTableDecks();

	$count = 0;
	for ($i = 0; $i < count($tableDecks); $i++) {
		for ($j = 0; $j < $i; $j++) {
			$count += isMatchPlayed($tableDecks[$i],$tableDecks[$j]);
		}
	}

	return $count;
}

function getMaxMatches () {
	$tableDecks = getTableDecks();

	// Somme de i à n = n * (n+1) / 2
	// Il y a (n-1) matches au plus
	return count($tableDecks)*(count($tableDecks)-1)/2;
}

function getAvancement () {
	return round( getMatchesPlayed() / getMaxMatches() * 100 , 0);
}
