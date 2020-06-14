<?php
/*************************
 * changementDeck        *
 * @param tableau $_POST *
 * @return "OK" ou error *
 *************************/
function corrigerDeck ($informations) {
	// On vérifie que l'utilisateur est déjà inscrit
	$controle = dejaInscrit($informations['id']);
	if ($controle == 'XXX') {
		return "Erreur 000 : Utilisateur non inscrit";
	}
	
	// On récupère l'ancien ID du deck
	$id_deck = getIdDeck($informations['hash']);
	
	// On modifie les infos
	updateDeck($id_deck,$informations);
	
	
	// Ajout dans la table des decks
	//$informations['id_deck'] = ajoutDeck($informations);
	
	return "OK";
}

function getIdDeck ($hash) {
	$sql = "SELECT id_deck FROM decks WHERE hash LIKE '%$hash%';";
	return executerRequete($sql)->fetchColumn();
}

function updateDeck ($id_deck, $parametres) {
	$deck = array(
		':liste'		=>	getListeJSON($parametres['liste']),
		':general'		=>	getGeneralJSON($parametres['liste'])
	);
	$sql =	"UPDATE decks ".//
			"SET liste = :liste, general = :general ".//
			"WHERE id_deck = $id_deck;";
	return executerRequete($sql, $deck)->fetchColumn();
}