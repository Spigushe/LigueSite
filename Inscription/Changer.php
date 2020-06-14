<?php
/*************************
 * changementDeck        *
 * @param tableau $_POST *
 * @return "OK" ou error *
 *************************/
function changementDeck ($informations) {
	// On vérifie que l'utilisateur est déjà inscrit
	$controle = dejaInscrit($informations['id']);
	if ($controle == 'XXX') {
		return "Erreur 000 : Utilisateur non inscrit";
	}

	// On vérifie que l'utilisateur a bien un nouveau hash
	$controle = nouveauHash($informations);
	if ($controle != 'XXX') {
		// On a déjà ce hash pour ce joueur
		return $_SESSION['dicoErreurs'][$controle];
	}

	// Le deck actuel devient "ancien"
	setAncienDeck($informations['id']);

	// Ajout dans la table des decks
	$informations['id_deck'] = ajoutDeck($informations);

	return "OK";
}

function nouveauHash ($parametres) {
	if (isset($parametres['id']) && ($parametres['id'] != "")) {
		// On va executer la requete 'verificationParticipant'
		$requete = executerRequete("SELECT hash FROM decks WHERE est_joue = 1 AND id_discord = " . $parametres['id']);

		// On va regarder le résultat
		while ($resultat = $requete->fetch()) {
			if ($resultat['hash'] == $parametres['hash']) {
				return 'e102';
			}
		}
		return 'XXX';
	} else {
		return '001';
	}
}

function setAncienDeck ($id_discord) {
	return executerRequete("UPDATE decks SET est_joue = '0' WHERE id_discord = $id_discord;");
}
