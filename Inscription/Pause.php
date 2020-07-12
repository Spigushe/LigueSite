<?php

function Action ($params)
{
	// On vérifie que l'utilisateur est déjà inscrit
	if (dejaInscrit($params['id']) == 'XXX') {
		return "Erreur 000 : Utilisateur non inscrit";
	}

	$pseudo = getPseudo($params['id']);
	$ligue = getLigue($params['id']);

	return "$pseudo--$ligue";
}
