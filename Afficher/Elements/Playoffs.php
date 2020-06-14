<?php
function Affichage ($saison, $ligue) {
    // Nombre de Playoffs
    $playoffs = getPlayoffs ($saison);

    // Préparation
    $retour = "";

    for ($i = 0; $i < count($playoffs); $i++) {
        // On prépare les variables pour l'Affichage
        $infos = getInfosLigue($playoffs[$i]['id_ligue']);
        $resultats = getResultatsLigue($playoffs[$i]['id_ligue']);

        $retour .= "<h3>" .$playoffs[$i]['nom_ligue'] ."</h3>";
        $retour .= "<h3 class='mt-3'>Détail du metagame</h3>";
    	$retour .= tableauMetagame ($infos, $resultats);
    	$retour .= "<div class='my-5'></div>";
    	//$retour .= "<h3 class='mt-3'>Résumé des parties</h3>";
    	//$retour .= tableauResultats ($infos, $resultats);
    	//$retour .= "<div class='my-5'></div>";

    }

    return $retour;
}

function getPlayoffs ($saison) {
    $sql = "SELECT * FROM ligues WHERE nom_ligue LIKE '%Play%' AND num_saison = ?;";
    $requete = executerRequete($sql, array($saison));

    $retour = array();
    while ($resultat = $requete->fetch()) {
        $retour[] = $resultat;
    }

    return $retour;
}

function getInfosLigue ($id_ligue) {
    $liste_decks = getDecksLigue ($id_ligue);
	$retour = array();

	for ($i = 0; $i < count($liste_decks); $i++) {
		$sql =	"SELECT " . //
					"decks.*, " . //
					"participants.* " . //
				"FROM decks " . //
				"JOIN participants " . //
					"ON participants.id_discord = decks.id_discord " . //
				"WHERE decks.id_deck = ? ;";
		$retour[] = executerRequete($sql,array($liste_decks[$i]))->fetch();
	}

	return triAlphabetique($retour, 'pseudo');
}

function getDecksLigue ($id_ligue) {
    $sql =	"SELECT liste_decks FROM ligues WHERE id_ligue = ? ;";
	$resultats = executerRequete($sql, array($id_ligue))->fetchColumn();
	return preg_split("/, /i",$resultats);
}

function getResultatsLigue ($id_ligue) {
	/**
	 * @params $saison et $ligue via $_GET
	 * @return tableau (deck => (victoires => (), defaites => () )
	 **/
	$liste_decks = getDecksLigue ($id_ligue);
	$retour = array();

	// On regarde la liste des id_deck1 d'abord
	for ($i = 0; $i < count($liste_decks); $i++) {
		$sql =	"SELECT ".//
					"participants.id_discord, ".//
					"participants.pseudo, ".//
					"decks.id_deck, ".//
					"decks.general, ".//
					"resultats.resultat_deck1, ".//
					"resultats.resultat_deck2, ".//
					"resultats.id_deck1, ".//
					"resultats.id_deck2 ".//
				"FROM resultats ".//
				"JOIN decks ".//
					"ON resultats.id_deck1 = decks.id_deck ".//
					"OR resultats.id_deck2 = decks.id_deck ".//
				"JOIN participants ".//
					"ON decks.id_discord = participants.id_discord ".//
				"WHERE decks.id_deck = " . $liste_decks[$i] . " AND id_resultat > 160;";
		$requete = executerRequete($sql);

		while ($resultat = $requete->fetch()) {
            if (in_array($resultat['id_deck1'],$liste_decks) && in_array($resultat['id_deck2'],$liste_decks)) {
    			// On regarde le résultat de la partie
    			$deck_gagnant = getGagnantPartie($resultat['resultat_deck1'],$resultat['resultat_deck2']);
    			$deck_perdant = ($deck_gagnant == 'deck1') ? 'deck2' : 'deck1';

    			// Est-ce une victoire ?
    			$resultat_partie = ($resultat["id_$deck_gagnant"] == $liste_decks[$i]) ? "V" : "D";

    			// On stocke le résultat
    			if ($resultat_partie == "V") {
    				$retour[$resultat['pseudo']]['victoires'][] = array(
    					'joueur'	=> getJoueur($resultat["id_$deck_perdant"]),
    					'general'	=> getGeneral($resultat["id_$deck_perdant"]),
    					'resultat'	=> $resultat["resultat_$deck_gagnant"]."-".$resultat["resultat_$deck_perdant"]
    				);
    			} else {
    				$retour[$resultat['pseudo']]['defaites'][] = array(
    					'joueur'	=> getJoueur($resultat["id_$deck_gagnant"]),
    					'general'	=> getGeneral($resultat["id_$deck_gagnant"]),
    					'resultat'	=> $resultat["resultat_$deck_perdant"]."-".$resultat["resultat_$deck_gagnant"]
    				);
                }
			}
		}
	}

	return $retour;
}

function tableauMetagame ($infos, $resultats) {
	ob_start();
	require_once('Afficher/Elements/Tableaux/TableauMetagame.php');
	return ob_get_clean();
}

function tableauParties ($infos, $resultats) {
	ob_start();
	require_once('Afficher/Elements/Tableaux/TableauParties.php');
	return ob_get_clean();
}

function tableauResultats ($infos, $resultats) {
	ob_start();
	require_once('Afficher/Elements/Tableaux/TableauResultats.php');
	return ob_get_clean();
}
