<?php

function Action ($params) {
	// On vérifie si l'id_discord et le hash sont déjà reliés
	if (dejaEnregistre($params)) {
		return __ERREURS__['e102'];
	}

	// Bascule de tous les autres decks en non actif
	setAncienDeck($params['id']);

	// Ajout
	return ajoutDeck($params);
}

function dejaEnregistre ($params) {
	$sql = "SELECT hash FROM decks WHERE id_discord = :id AND est_joue = 1;";
	$donnees = array(
		':id' => $params['id'],
	);

	return (executerRequete($sql,$donnees)->fetch()['hash'] == $params['hash']);
}
