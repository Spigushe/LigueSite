<?php

// Fonction utilisée pour les pauses et les drops
function endLigue ($joueur)
{
	// Infos sur le joueur et la ligue
	$matchesJoues = array_merge(adversairesRencontres($joueur),array($joueur['deck']));
	$listeAdversaire = preg_split("/, /i",getInfoLigue($joueur)['liste_decks']);

	// Matches restants
	$matchesRestants = getMatchesRestants($matchesJoues, $listeAdversaire);

	// Faire perdre les matches restants
	loseMatches($joueur,$matchesRestants);

	return false;
}

function getMatchesRestants ($joues, $total)
{
	$restants = array();
	for ($i = 0; $i < count($total); $i++) {
		if (in_array($total[$i], $joues))
		{
			continue;
		}
		$restants[] = $total[$i];
	}
	return $restants;
}

/*****************************/
/*****************************/
/******                 ******/
/******      TABLE      ******/
/******   PARTICIPANTS  ******/
/******                 ******/
/******     GETTERS     ******/
/******                 ******/
/*****************************/
/*****************************/
function dejaInscrit ($id_discord = "")
{
	// On va executer la requete de vérification
	$sql = "SELECT COUNT(*) FROM participants WHERE id_discord = :id;";
	$requete = executerRequete($sql,array(':id'=>$id_discord));

	// Si on a un résultat
	if ($requete->fetchColumn() > 0)
	{
		return 'e101';
	}

	// Sinon
	return 'XXX';
}

function getLigue ($id_discord)
{
	$sql = "SELECT nom_role FROM participants WHERE id_discord = :id";
	$resultat = executerRequete($sql,array(':id'=>$id_discord))->fetchColumn();

	// Traitement du retour
	if ($resultat == '')
	{
		return 'e107';
	}

	return $resultat;
}

function getPseudo ($id_discord)
{
	$sql = "SELECT pseudo FROM participants WHERE id_discord = :id;";
	return executerRequete($sql,array(':id'=>$id_discord))->fetchColumn();
}

function getRole ($id_discord)
{
	$sql = "SELECT nom_role FROM participants WHERE id_discord = :id;";
	return executerRequete($sql,array(':id'=>$id_discord))->fetchColumn();
}

function getJoueursRole ($role)
{
	$sql = "SELECT * FROM participants p
			JOIN decks d ON p.id_discord = d.id_discord
			WHERE p.nom_role = :r AND est_joue = 1;";
	$donnees = array(':r'=>$role);
	$requete = executerRequete($sql,$donnees);

	$retour = array();
	while ($resultat = $requete->fetch())
	{
		$retour[] = $resultat;
	}

	return $retour;
}

/*****************************/
/*****************************/
/******                 ******/
/******      TABLE      ******/
/******   PARTICIPANTS  ******/
/******                 ******/
/******     SETTERS     ******/
/******                 ******/
/*****************************/
/*****************************/
function retourJoueur ($id)
{
	$sql = "UPDATE participants SET nom_role = 'Placement' WHERE id_discord = :id;";
	executerRequete($sql,array(':id'=>$id));
	return "OK--" . getIdRole('Placement');
}

function inscriptionJoueur ($parametres)
{
	/***** Champs de la table decks
	@(), id_discord, pseudo, nom_role
	*****/
	$participant = array(
		':id_discord'	=>	$parametres['id'],
		':pseudo'		=>	$parametres['pseudo'],
		':nom_role'		=>	'Placement'
	);
	$sql = "INSERT INTO `participants` (id_discord, pseudo, nom_role) VALUES (:id_discord, :pseudo, :nom_role);";
	executerRequete($sql, $participant);
	return "OK--" . getIdRole('Placement');
}

function departJoueur ($id)
{
	$sql = "UPDATE participants SET nom_role = '' WHERE id_discord = :id;";
	executerRequete($sql,array(':id'=>$id));
	return false;
}

/*****************************/
/*****************************/
/******                 ******/
/******      TABLE      ******/
/******      ROLES      ******/
/******                 ******/
/******     GETTERS     ******/
/******                 ******/
/*****************************/
/*****************************/
function getIdRole ($nom)
{
	$sql = "SELECT id_discord FROM roles WHERE nom_role = :nom ORDER BY id_discord DESC;";
	return executerRequete($sql,array(':nom'=>$nom))->fetchColumn();
}

function roleExiste ($nom) {
	$sql = "SELECT COUNT(*) FROM roles WHERE nom_role LIKE '%$nom%';";
	$requete = executerRequete($sql);
	// On va regarder le résultat
	if ($requete->fetchColumn() > 0) { return 'XXX'; }
	return 'e108';
}

/*****************************/
/*****************************/
/******                 ******/
/******      TABLE      ******/
/******      DROPS      ******/
/******                 ******/
/******     SETTERS     ******/
/******                 ******/
/*****************************/
/*****************************/
function dropJoueur ($joueur)
{
	$sql = "INSERT INTO drops (id_discord,ligue,saison) VALUES (:id, :ligue, :saison);";
	$data = array(
		':id'		=> $joueur['id'],
		':ligue'	=> $joueur['ligue'],
		':saison'	=> $joueur['saison'],
	);
	executerRequete($sql,$data);
	return "OK";
}

/*****************************/
/*****************************/
/******                 ******/
/******      TABLE      ******/
/******      DECKS      ******/
/******                 ******/
/******     GETTERS     ******/
/******                 ******/
/*****************************/
/*****************************/
function getDeck ($id)
{
	$sql = "SELECT * FROM decks WHERE id_discord = :id AND est_joue = 1;";
	return executerRequete($sql,array(':id'=>$id))->fetch();
}

/*****************************/
/*****************************/
/******                 ******/
/******      TABLE      ******/
/******      DECKS      ******/
/******                 ******/
/******     SETTERS     ******/
/******                 ******/
/*****************************/
/*****************************/
function decksNonJoues ($id_discord)
{
	return executerRequete("UPDATE decks SET est_joue = '0' WHERE id_discord = :id;",array(':id'=>$id_discord));
}

/*****************************/
/*****************************/
/******                 ******/
/******      TABLE      ******/
/******    RESULTATS    ******/
/******                 ******/
/******     GETTERS     ******/
/******                 ******/
/*****************************/
/*****************************/
function adversairesRencontres ($joueur)
{
	$sql = "SELECT * FROM resultats WHERE (id_deck1 = :id OR id_deck2 = :id) AND saison = :s AND ligue = :l;";
	$donnees = array(
		':id' => $joueur['deck'],
		':s'  => $joueur['saison'],
		':l'  => $joueur['ligue'],
	);
	$requete = executerRequete($sql,$donnees);

	$opponents = array();
	while ($resultat = $requete->fetch())
	{
		$opponents[] = ($resultat['id_deck1'] == $joueur['deck']) ? $resultat['id_deck2'] : $resultat['id_deck1'];
	}
	return $opponents;
}

/*****************************/
/*****************************/
/******                 ******/
/******      TABLE      ******/
/******    RESULTATS    ******/
/******                 ******/
/******     SETTERS     ******/
/******                 ******/
/*****************************/
/*****************************/
function loseMatches ($joueur, $matches)
{
	$sql = "INSERT INTO resultats (id_deck1,id_deck2,resultat_deck1,resultat_deck2,saison,ligue) VALUES (:id1,:id2,0,2,:s,:l);";
	$donnees = array(
		':id1'	=> $joueur['deck'],
		':s'	=> $joueur['saison'],
		':l'	=> $joueur['ligue'],
	);

	for ($i = 0; $i < count($matches); $i++)
	{
		$donnees[':id2'] = $matches[$i];
		executerRequete($sql, $donnees);
	}

	return false;
}

/*****************************/
/*****************************/
/******                 ******/
/******      TABLE      ******/
/******     LIGUES      ******/
/******                 ******/
/******     GETTERS     ******/
/******                 ******/
/*****************************/
/*****************************/
function getInfoLigue ($params)
{
	$sql = "SELECT * FROM ligues WHERE num_saison = :s AND nom_ligue = :l;";
	$donnees = array(
		':s' => $params['saison'],
		':l' => $params['ligue'],
	);

	return executerRequete($sql,$donnees)->fetch();
}
