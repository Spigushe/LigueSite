<?php
/*************************
 * nouveauParticipant    *
 * @param tableau $_POST *
 * @return "OK" ou error *
 *************************/
function nouveauParticipant ($informations) {
	// Contrôle de l'unicité de l'inscription
	$controle = dejaInscrit($informations['id']);
	if ($controle != 'XXX') {
		return $_SESSION['dicoErreurs'][$controle];
	}
	// On vérifie que l'inscription ne vient pas d'un drop
	$dejaDrop = dropPrecedent($informations['id']);
	if ($dejaDrop == '101') {
		return retourJoueurSuiteDrop($informations);
	}
	
	// Ajout dans la table des participants
	ajoutParticipant($informations);
	
	// Ajout dans la table des decks
	ajoutDeck($informations);
	
	return "OK--" . getIdRole('Placement');
}

function ajoutParticipant ($parametres) {
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
	return false;
}

function retourJoueurSuiteDrop ($parametres) {
	// On réactive son ID discord
		// Dans la table des participants
		reactivationIdJoueur($parametres['id'], "participants");
		// Dans la table des decks
		reactivationIdJoueur($parametres['id'], "decks");
	
	// On ajoute son nouveau deck
	ajoutDeck($parametres);
	
	return "OK--" . getIdRole('Placement');
}

function reactivationIdJoueur ($id_discord, $table) {
	$sql =	"UPDATE $table ".//
			"SET id_discord = '$id_discord' ".//
			"WHERE id_discord LIKE '%$id_discord%';";
	executerRequete($sql);
}

function getIdRole ($nom) {
	return executerRequete("SELECT id_discord FROM roles WHERE nom_role LIKE '%$nom%' ORDER BY id_discord DESC;")->fetchColumn();
}