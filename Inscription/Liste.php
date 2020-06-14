<?php
/*************************
 * nouveauParticipant    *
 * @param tableau $_POST *
 * @return "OK" ou error *
 *************************/
function listeLigue ($informations) {
	// On vérifie que la ligue existe
	$controle = roleExiste($informations['role']);
	if ($controle != 'XXX') {
		return $_SESSION['dicoErreurs'][$controle];
	}

	// On récupère la liste des joueurs avec ce rôle
	$liste = listeJoueurs($informations['role']);

	$retour = "";
	for ($i = 0; $i < count($liste); $i++) {
		if ($retour != "") $retour .= " ";
		$retour .= $liste[$i]['pseudo'] . "(" . $liste[$i]['hash'] . ")";
	}

	return $retour;
}

function roleExiste ($nom_role = "") {
	if ($nom_role != "") {
		// On va executer la requete de vérification
		$sql = "SELECT COUNT(*) FROM roles WHERE nom_role LIKE '%$nom_role%';";
		$requete = executerRequete($sql);
		// On va regarder le résultat
		if ($requete->fetchColumn() > 0) { return 'XXX'; }
		return 'e108';
	}
	return '001';
}

function listeJoueurs ($nom_role) {
	$sql =	"SELECT " . //
				"participants.pseudo, " . //
				"decks.hash " . //
			"FROM participants " . //
			"JOIN decks " . //
				"ON decks.id_discord = participants.id_discord " . //
			"WHERE participants.nom_role LIKE '%$nom_role%'" . //
				"AND decks.est_joue = 1;";
	$requete = executerRequete($sql);

	$retour = array();
	while ($resultat = $requete->fetch()) {
		$retour[] = array(
			'pseudo'	=>	$resultat['pseudo'],
			'hash'		=>	$resultat['hash']
		);
	}
	return $retour;
}
