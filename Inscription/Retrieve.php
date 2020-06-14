<?php
/*************************
 * nouveauParticipant    *
 * @param tableau $_POST *
 * @return "OK" ou error *
 *************************/
function envoyerListe ($informations) {
    // On vérifie que le joueur existe
    $controle = dejaInscrit($informations['id']);
	if ($controle == 'XXX') {
		return "Erreur 000 : Utilisateur non inscrit";
	}

    $deck = getDeck($informations['id']);
    $hash = getHash($informations['id']);


    $retour = "Here's the list you submitted:\nhttps://magic-ville.fr/fr/decks/showdeck.php?ref=".$deck;
    $retour .= "\nRegistered hash is " . $hash;

    echo $retour;
}

function getDeck ($id_discord) {
    $sql =  "SELECT cle_MV " . //
            "FROM decks " . //
            "WHERE decks.id_discord = ? AND est_joue = 1;";
    $requete = executerRequete($sql,array($id_discord));

    $deck = $requete->fetch()['cle_MV'];
    return $deck;
}

function getHash ($id_discord) {
    $sql =  "SELECT hash " . //
            "FROM decks " . //
            "WHERE decks.id_discord = ? AND est_joue = 1;";
    $requete = executerRequete($sql,array($id_discord));

    $deck = $requete->fetch()['cle_MV'];
    return $deck;
}
