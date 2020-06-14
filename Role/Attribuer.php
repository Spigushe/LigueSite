<?php
/*************************
 * nouveauRole           *
 * @param tableau $_POST *
 * @return
 * id_discord_joueur--id_discord_ancien_role--id_discord_nouveau_role *
 *************************/
function attribuerRole ($informations) {
	// Récupérer le pseudo discord du joueur cockatrice
	if (isset($informations['pseudo']) && ($informations['pseudo'] == '')) {
		return $_SESSION['dicoErreurs']['002'];
	}
	$id_joueur = recupererIdJoueur($informations['pseudo']);

	// Récupérer l'id de l'ancien rôle
	$id_ancien = recupererIdRoleJoueur($informations['pseudo']);

	// Récupérer l'id du nouveau rôle
	if (isset($informations['role']) && ($informations['role'] == '')) {
		return $_SESSION['dicoErreurs']['003'];
	}
	$id_nouveau = recupererIdRole($informations['role']);

	// Retour de la fonction
	modifierRole($informations['pseudo'], $informations['role']);
	return $id_joueur . '--' . $id_ancien . '--' . $id_nouveau;
}

function recupererIdJoueur ($pseudo) {
	return executerRequete("SELECT id_discord FROM participants WHERE pseudo LIKE '%$pseudo%' ORDER BY id_discord DESC;")->fetchColumn();
}

function recupererIdRoleJoueur ($pseudo) {
	$sql =	"SELECT roles.id_discord ".//
			"FROM roles ".//
			"INNER JOIN participants ON roles.nom_role LIKE participants.nom_role ".//
			"WHERE participants.pseudo LIKE '%$pseudo%';";
	return executerRequete($sql)->fetchColumn();
}

function recupererIdRole ($nom) {
	return executerRequete("SELECT id_discord FROM roles WHERE nom_role LIKE '%$nom%' ORDER BY id_discord DESC;")->fetchColumn();
}

function modifierRole ($pseudo, $role) {
	$sql =	"UPDATE participants ".//
			"SET `nom_role` = '$role' ".//
			"WHERE pseudo LIKE '%$pseudo%'";
	return executerRequete($sql);
}
