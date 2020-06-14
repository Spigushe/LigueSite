<?php
/*************************
 * changementDeck        *
 * @param tableau $_POST *
 * @return pseudo_cocka--nom_role--id_role *
 *************************/
function dropJoueur ($informations) {
	// On vérifie que l'utilisateur est déjà inscrit
	$controle = dejaInscrit($informations['id']);
	if ($controle == 'XXX') {
		return "Erreur 000 : Utilisateur non inscrit";
	}
	
	// On récupère le pseudo Cockatrice
	$pseudo = getPseudo($informations['id']);
	
	// On récupère le nom du rôle
	$role = getRole($informations['id']);
	
	// On récupère l'identifiant discord du role
	$id_role = getIdRole($role);
	
	// On met tous ses decks en 'non_joué'
	decksNonJouesParId($informations['id']);
	
	// On marque le joueur comme drop
	setDropJoueur($informations['id']);
	
	return $pseudo . "--" . $role . "--" . $id_role;
}

function getPseudo ($id_discord) {
	$sql = "SELECT pseudo FROM participants WHERE id_discord = $id_discord;";
	return executerRequete($sql)->fetchColumn();
}

function getRole ($id_discord) {
	$sql = "SELECT nom_role FROM participants WHERE id_discord = $id_discord;";
	return executerRequete($sql)->fetchColumn();
}

function getIdRole ($role) {
	$sql = "SELECT id_discord FROM roles WHERE nom_role LIKE '%$role%';";
	return executerRequete($sql)->fetchColumn();
}

function decksNonJouesParId ($id_discord) {
	$sql =  "UPDATE decks ".//
			"SET est_joue = 0 ".//
			"WHERE id_discord = $id_discord;";
	executerRequete($sql);
}

function setDropJoueur ($id_discord) {
	// Update de la table des participants
	$sql = 	"UPDATE participants ".//
			"SET id_discord = 'D$id_discord' ".//
			"WHERE id_discord = $id_discord;";
	executerRequete($sql);
	// Update de la table decks
	$sql = 	"UPDATE decks ".//
			"SET id_discord = 'D$id_discord' ".//
			"WHERE id_discord = $id_discord;";
	executerRequete($sql);
}