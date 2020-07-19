<?php

function Action ($informations)
{
	// Contrôles
	if (!isset($informations['pseudo']) || !isset($informations['role']))
	{
		return "Erreur: Il manque des informations";
	}
	if (($informations['pseudo'] == "") || ($informations['role'] == ""))
	{
		return "Erreur: Les informations sont incomplètes";
	}

	// Collecte des informations de la base
	$joueur = array(
		'pseudo'	=> $informations['pseudo'],
	);
	getInfosJoueur($joueur);

	// Collecte des informations du nouveau role
	$role = getRole($informations['role']);

	// Modification dans la base
	modifierRole($joueur,$role);

	// Retour pour le bot : id_joueur--id_acien--id_nouveau
	return $joueur['id_discord']."--".$joueur['id_role']."--".$role['id_role'];
}

function getInfosJoueur (&$joueur)
{
	$sql = "SELECT * FROM participants p JOIN roles r ON p.nom_role = r.nom_role WHERE p.pseudo LIKE :pseudo;";
	$donnees = array(
		':pseudo' => $joueur['pseudo'],
	);
	$requete = executerRequete($sql,$donnees);
	$joueur = $requete->fetch();

	return false;
}

function getRole ($param)
{
	$sql = "SELECT * FROM roles WHERE nom_role LIKE :role;";
	$donnees = array(
		':role' => $param
	);
	return executerRequete($sql,$donnees)->fetch();
}

function modifierRole ($joueur, $role)
{
	$sql = "UPDATE participants SET nom_role = :role WHERE id_discord = :id;";
	$donnees = array(
		':role'	=> $role['nom_role'],
		':id'	=> $joueur['id_discord'],
	);
	executerRequete($sql,$donnees);

	return false;
}
