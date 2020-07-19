<?php

function Action ($params) {
	// Premier contrôle
	if (!isset($params['id']) || ($params['id'] == "")) {
		// données manquantes
		return __ERREURS__['001'];
	}

	// Est-ce que l'ID_DISCORD est déjà dans la base
	if (dejaInscrit($params['id']) != 'XXX') {
		// renvoie 'e101' si déjà inscrit

		/*******  Utilisateur déjà dans la base  *******/
		if (getLigue($params['id']) != 'e107') {
			// renvoie 'e107' si pas de ligue

			/*******  Utilisateur déjà dans la base  *******/
			/******* Utilisateur affecté à une ligue *******/
			return __ERREURS__['e101'];
		}

		/*******  Utilisateur déjà dans la base  *******/
		/******* Utilisateur pas affecté à ligue *******/

		// On remet le joueur en Placement
		return retourJoueur($params['id']);
	}

	// on inscrit le joueur
	return inscriptionJoueur($params);
}
