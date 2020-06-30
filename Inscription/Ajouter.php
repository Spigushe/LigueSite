<?php

function Action ($params)
{
	// Premier contrôle
	if (!isset($params['id']) || ($params['id'] == ""))
	{
		// données manquantes
		return $_SESSION['dicoErreurs']['001'];
	}

	// Est-ce que l'ID_DISCORD est déjà dans la base
	if (dejaInscrit($params['id']) != 'XXX') // e101 si déjà inscrit
	{
		// L'utilisateur est déjà dans la base
		if (getLigue($params['id']) != 'e107') // e107 si pas de ligue
		{
			// Utilisateur déjà inscrit et avec une ligue
			return $_SESSION['dicoErreurs']['e101'];
		}

		// On remet le joueur en Placement
		return retourJoueur($params['id']);
	}

	// on inscrit le joueur
	return inscriptionJoueur($params);
}
