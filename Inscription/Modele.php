<?php
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
	return ajoutDrop();
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
	)
	executerRequete($sql,$data);
	return "OK";
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
