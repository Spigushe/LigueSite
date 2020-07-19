<?php
/*************************
 * nouveauRole           *
 * @param tableau $_POST *
 * @return "OK" ou error *
 *************************/
function nouveauRole ($informations) {
	// Contrôle de l'unicité de l'inscription
	$controle = dejaInscrit($informations['id_discord']);
	if ($controle != 'XXX') {
		return __ERREURS__[$controle];
	}

	// Ajout dans la table des decks
	ajoutRole($informations);

	return "OK";
}

function dejaInscrit ($id_discord) {
	if (isset($id_discord) && ($id_discord != "")) {
		// On va executer la requete 'verificationParticipant'
		$requete = executerRequete("SELECT COUNT(*) FROM roles WHERE id_discord = $id_discord;");

		// On va regarder le résultat
		if ($requete->fetchColumn() > 0) { return 'e103'; }
		return 'XXX';
	} else {
		return '001';
	}
}

function ajoutRole ($parametres) {
	/***** Champs de la table decks
	@(), id_discord, nom_role
	*****/
	$sql = "INSERT INTO `roles` (id_discord, nom_role)".//
						"VALUES (:id_discord, :nom_role);";

	$donnees = array(
		':id_discord'	=> $parametres['id_discord'],
		':nom_role'		=> $parametres['nom']
	);

	return executerRequete($sql,$donnees);
}
