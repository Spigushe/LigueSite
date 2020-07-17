<?php

// Fonction utilisée pour les pauses et les drops
function endLigue ($joueur)
{
	// Infos sur le joueur et la ligue
	$listeAdversaire = preg_split("/, /i",getInfoLigue($joueur)['liste_decks']);

	// Faire perdre les matches	
	for ($i = 0; $i < count($listeAdversaire); $i++)
	{
		if (matchJoue($joueur['deck'],$listeAdversaire[$i]) > 0)
		{
			modifierResultat(matchJoue($joueur['deck'],$listeAdversaire[$i]),$joueur['deck'],$listeAdversaire[$i]);
		}
		else
		{
			ajouterResultat($joueur,$listeAdversaire[$i]);
		}
	}

	return false;
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
function matchJoue ($id1, $id2)
{
	$sql = "SELECT id_resultat FROM resultats WHERE ((id_deck1 = :id1 AND id_deck2 = :id2) OR (id_deck2 = :id1 AND id_deck1 = :id2)) AND saison = :s AND ligue = :l;";
	
	$donnees = array(
		':id1'	=> $id1,
		':id2'	=> $id2,
		':s'	=> $joueur['saison'],
		':l'	=> $joueur['ligue'],
	);

	return max(0,executerRequete($sql,$donnees)->fetch()['id_resultat']);
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
function ajouterResultat ($joueur,$autreDeck)
{
	$sql = "INSERT INTO resultats (id_deck1,id_deck2,resultat_deck1,resultat_deck2,saison,ligue) VALUES (:id1,:id2,0,2,:s,:l);";
	$donnees = array(
		':id1'	=> $joueur['deck'],
		':id2'	=> $autreDeck,
		':s'	=> $joueur['saison'],
		':l'	=> $joueur['ligue'],
	);
	executerRequete($sql, $donnees);
	return false;
}

function modifierResultat ($id_resultat, $deckDefaite, $autreDeck)
{
	$sql = "UPDATE resultats SET id_deck1 = :id1 AND id_deck2 = :id2 AND resultat_deck1 = 0 AND resultat_deck2 = 2 WHERE id_resultat = :idr;";
	
	$donnees = array(
		':idr'	=> $id_resultat,
		':id1'	=> $deckDefaite,
		':id2'	=> $autreDeck,
	);
	
	executerRequete($sql,$donnees);
	
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
