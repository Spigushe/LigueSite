<?php

function Action ($params)
{
	// On vérifie que l'utilisateur est déjà inscrit
	if (dejaInscrit($params['id']) == 'XXX') {
		return "Erreur 000 : Utilisateur non inscrit";
	}

	// infos sur le joueur
	$joueur = array(
		'id'		=> $params['id'],
		'pseudo'	=> getPseudo($params['id']),
		'ligue'		=> getLigue($params['id']),
		'saison'	=> (getLigue($params['id']) == 'Placement') ? __SAISON__ +1 : __SAISON__,
		'deck'		=> getDeck($params['id'])['id_deck'],
	);

	// On bascule tous les résultats restants à 0-2
	endLigue($joueur);

	// Elements du message qui sera retourné au bot
	$pseudo = getPseudo($joueur['id']);
	$ligue = getLigue($joueur['id']);

	// On vérifie que l'utilisateur fait partie d'une ligue
	return (isset($_SESSION['dicoErreurs'][$ligue])) ? $_SESSION['dicoErreurs'][$ligue] : $joueur['pseudo']."--".$joueur['ligue'];
}
