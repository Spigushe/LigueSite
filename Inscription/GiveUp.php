<?php
/*************************
 * changementDeck        *
 * @param tableau $_POST *
 * @return pseudo_cocka--nom_role *
 *************************/
function mettreEnPause ($informations) {
	// On vérifie que l'utilisateur est déjà inscrit
	$controle = dejaInscrit($informations['id']);
	if ($controle == 'XXX') {
		return "Erreur 000 : Utilisateur non inscrit";
	}
	
	// On récupère le pseudo Cockatrice
	$pseudo = getPseudo($informations['id']);
	
	// On récupère le nom du rôle
	$role = getRole($informations['id']);
	
	// On met tous ses decks en 'non_joué'
	decksNonJouesParId($informations['id']);
	
	return $pseudo . "--" . $role;
}

function getPseudo ($id_discord) {
	$sql = "SELECT pseudo FROM participants WHERE id_discord = $id_discord;";
	return executerRequete($sql)->fetchColumn();
}

function getRole ($id_discord) {
	$sql = "SELECT nom_role FROM participants WHERE id_discord = $id_discord;";
	return executerRequete($sql)->fetchColumn();
}

function decksNonJouesParId ($id_discord) {
	$sql =  "UPDATE decks ".//
			"SET est_joue = 0 ".//
			"WHERE id_discord = $id_discord;";
	executerRequete($sql);
}