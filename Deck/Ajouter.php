<?php

function Action ($params) {
	// Contrôles
	if (dejaInscrit($params['id']) == 'XXX') {
		return "Erreur 000 : Utilisateur non inscrit";
	}

	// Bascule de tous les autres decks en non actif
	setAncienDeck($params['id']);

	// Ajout
	return ajoutDeck($params);
}
