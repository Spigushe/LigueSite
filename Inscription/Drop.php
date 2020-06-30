<?php

function Action ($params)
{
	// On vérifie que l'utilisateur est déjà inscrit
	if (dejaInscrit($params['id']) == 'XXX') {
		return "Erreur 000 : Utilisateur non inscrit";
	}

	// On récupère ses infos
	$joueur = array(
		'id'		=> $params['id'],
		'pseudo'	=> getPseudo($params['id']),
		'ligue'		=> getLigue($params['id']),
		'saison'	=> (getLigue($params['id']) == 'Placement') ? __SAISON__ +1 : __SAISON__,
	)

	// On le retire de la ligue actuelle
	departJoueur($joueur['id']);

	// On l'ajoute à la table des drops
	dropJoueur($joueur);

	// On passe ses decks à non-joués
	decksNonJoues($joueur['id']);

	// On fait un retour au bot
	return $joueur['pseudo'] . "--" . $joueur['ligue'] . "--" . getIdRole($joueur['ligue']);
}
