<?php
/**************************
 **************************/
function getInformationsDansSaisonEtLigue ($saison, $ligue) {
	/**
	 * @params $saison et $ligue via $_GET
	 * @return liste des joueurs et des decks
	 **/
	$liste_decks = getDecksDansSaisonEtLigue ($saison,$ligue);
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

function triAlphabetique ($liste , $cle = 'pseudo') {
	if (count($liste) < 2) { return $liste; }

	for ($j = 0; $j < count($liste); $j++) {
		for ($i = 1; $i < count($liste); $i++) {
			if (strcasecmp($liste[$i-1][$cle],$liste[$i][$cle]) > 0) {
				$tampon = $liste[$i-1];
				$liste[$i-1] = $liste[$i];
				$liste[$i] = $tampon;
			}
		}
	}
	return $liste;
}

/**************************
 **************************/
function getResultatsDansSaisonEtLigue ($saison,$ligue) {
	/**
	 * @params $saison et $ligue via $_GET
	 * @return tableau (deck => (victoires => (), defaites => () )
	 **/
	$liste_decks = getDecksDansSaisonEtLigue ($saison,$ligue);
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
				"WHERE decks.id_deck = " . $liste_decks[$i] . ";";
		$requete = executerRequete($sql);

		while ($resultat = $requete->fetch()) {
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

	return $retour;
}

function SaisonEnCours () {
	$sql =	"SELECT " . //
				"num_saison " . //
			"FROM " . //
				"ligues " . //
			"ORDER BY " . //
				"num_saison DESC;";
	return executerRequete($sql)->fetchColumn();
}

function getScore ($id1, $id2) {
	if (!isset($_GET['saison']) && ($_GET['saison'] != "")) {
		$resultats = "resultats";
	} else if (SaisonEnCours() != $_GET['saison']) {
		$resultats = "resultats_saison".$_GET['saison'];
	} else {
		$resultats = "resultats";
	}

	$sql =	"SELECT " . //
				"id_deck1, " . //
				"resultat_deck1, " . //
				"resultat_deck2 " . //
			"FROM $resultats " . //
			"WHERE " . //
				"(id_deck1 = '$id1' AND id_deck2 = '$id2') " . //
				"OR " . //
				"(id_deck1 = '$id2' AND id_deck2 = '$id1') " . //
			"ORDER BY id_resultat DESC;";
	$requete = executerRequete($sql)->fetch();

	// Si le résultat n'existe pas
	if (gettype($requete) != 'array') {
		return array('victoires'=>0,'defaites'=>0);
	}

	// Traitement des retours
	$resultat1 = ($requete['resultat_deck1'] != "") ? $requete['resultat_deck1'] : 0 ;
	$resultat2 = ($requete['resultat_deck2'] != "") ? $requete['resultat_deck2'] : 0 ;

	// Envoi
	if ($requete['id_deck1'] != $id1) {
		return array('victoires'=>$resultat2,'defaites'=>$resultat1);
	}
	return array('victoires'=>$resultat1,'defaites'=>$resultat2);
}

/**************************
 * Fonction qui permet de *
 * récupérer la liste des *
 * participants à une     *
 * ligue donnée           *
 **************************/
function getDecksDansSaisonEtLigue ($saison,$ligue) {
	/**
	 * @params $saison et $ligue via $_GET
	 * @return liste des decks dans la ligue
	 **/
	$sql =	"SELECT liste_decks ".//
			"FROM ligues ".//
			"WHERE num_saison = '$saison' " .//
				"AND nom_ligue LIKE '%$ligue%' ;";

	$resultats = executerRequete($sql)->fetchColumn();
	return preg_split("/, /i",$resultats);
}

function getGagnantPartie ($resultat1, $resultat2) {
	if ($resultat1 > $resultat2) return 'deck1';
	return 'deck2';
}

function getJoueur ($id_deck) {
	$sql =	"SELECT ".//
				"participants.pseudo ".//
			"FROM decks ".//
			"JOIN participants ".//
				"ON participants.id_discord = decks.id_discord ".//
			"WHERE decks.id_deck = $id_deck;";
	return executerRequete($sql)->fetchColumn();
}

function getGeneral ($id_deck) {
	$sql =	"SELECT ".//
				"decks.general ".//
			"FROM decks ".//
			"JOIN participants ".//
				"ON participants.id_discord = decks.id_discord ".//
			"WHERE decks.id_deck = $id_deck;";
	return executerRequete($sql)->fetchColumn();
}

/**************************
 * Gestion de l'affichage *
 * des généraux et des    *
 * partenaires et         *
 * compagnons             *
 **************************/
function afficheGeneral ($texte, $place) {
	if ($place == "") return "";

	$contraintes = "";
	if (preg_match('/\//i',$texte)) $contraintes .= "P";
	if (preg_match('/\(/i',$texte)) $contraintes .= "C";

	switch ($place) {
		case 'principal':
			return afficheGeneralPrincipalContraintes($texte, $contraintes);
		case 'adversaire':
			return afficheGeneralAdversaireContraintes($texte, $contraintes);
		case 'resultat':
			return afficheGeneralResultatsContraintes($texte, $contraintes);
		case 'inline':
			return afficheGeneralInlineContraintes($texte, $contraintes);
	}
}

function afficheGeneralPrincipalContraintes ($texte, $contraintes) {
	if ($contraintes == "") return $texte;

	// Traitement des partenaires
	if (preg_match('/p/i',$contraintes)) {
		$liste_partners = (preg_match('/c/i',$contraintes)) ? preg_split('/\(/',$texte)[0] : $texte;
		$partenaires = array(preg_split('/\/\//i',$liste_partners)[0],preg_split('/\/\//i',$liste_partners)[1]);
		$retour = imagePartenaires("principal") . "<div>" . $partenaires[0] . "<br />" . $partenaires[1] . "</div>";
	}

	// Traitement des compagnons
	if (preg_match('/c/i',$contraintes)) {
		$compagnon = substr(preg_split('/\(/',$texte)[1],0,strlen(preg_split('/\(/',$texte)[1])-1);
		// S'il y a en plus des partenaires
		if (preg_match('/p/i',$contraintes)) {
			$retour .= "<div>" . imageCompagnon() . $compagnon . "</div>";
		}
		// S'il n'y a pas de partenaires
		else {
			$retour = preg_split('/\(/i',$texte)[0] . //
						"<div>" . imageCompagnon() . $compagnon . "</div>";
		}
	}

	return $retour;
}

function afficheGeneralAdversaireContraintes ($texte, $contraintes) {
	if ($contraintes == "") return $texte;

	// Traitement des partenaires
	if (preg_match('/p/i',$contraintes)) {
		// Les deux partenaires
		$partenaires = array(
			preg_split('/[\s,]+/',preg_split('/\/\//i',$texte)[0])[0],
			preg_split('/[\s,]+/',preg_split('/\/\//i',$texte)[1])[1]
		);
		// Le texte à afficher
		$liste_partners = (preg_match('/c/i',$contraintes)) ? preg_split('/\(/',$texte)[0] : $texte;
		//Le retour
		$retour = imagePartenaires() . //
			"<a class='text-decoration-none text-reset' title='$liste_partners'>" . //
			$partenaires[0] . " / " . $partenaires[1] . "</a>";
	}

	// Traitement des compagnons
	if (preg_match('/c/i',$contraintes)) {
		$compagnon = substr(preg_split('/\(/',$texte)[1],0,strlen(preg_split('/\(/',$texte)[1])-1);
		// S'il y a en plus des partenaires
		if (preg_match('/p/i',$contraintes)) {
			$retour .= " + " . imageCompagnon($compagnon);
		}
		// S'il n'y a pas de partenaires
		else {
			$retour = preg_split('/\(/i',$texte)[0] . //
						" + " . imageCompagnon($compagnon);
		}
	}

	return $retour;
}

function afficheGeneralResultatsContraintes($texte, $contraintes) {
	return afficheGeneralAdversaireContraintes ($texte, $contraintes);
}


function afficheGeneralInlineContraintes ($texte, $contraintes) {
	if ($contraintes == "") return $texte;

	// Traitement des partenaires
	if (preg_match('/p/i',$contraintes)) {
		// Le texte à afficher
		$liste_partners = (preg_match('/c/i',$contraintes)) ? preg_split('/\(/',$texte)[0] : $texte;
		// Les deux partenaires
		$partenaires = array(
			preg_split('/\/\//i',$liste_partners)[0],
			preg_split('/\/\//i',$liste_partners)[1]
		);
		//Le retour
		$retour = imagePartenaires() . $partenaires[0] . " / " . $partenaires[1];
	}

	// Traitement des compagnons
	if (preg_match('/c/i',$contraintes)) {
		$compagnon = substr(preg_split('/\(/',$texte)[1],0,strlen(preg_split('/\(/',$texte)[1])-1);
		// S'il n'y avait pas de partenaires, on va juste ajouter ce qu'il y a avant la parenthèse
		$retour = (preg_match('/p/i',$contraintes)) ? $retour : preg_split('/\(/i',$texte)[0];
		$retour .= " ( " . imageCompagnon() . " " . $compagnon . ")";
	}

	return $retour;
}

function imageCompagnon ($texte = "") {
	return "<img src='/Afficher/Icones/Companion.png' width='16px' title='$texte'  />";
}

function imagePartenaires ($place = "" , $texte = "") {
	if ($place == "principal") {
		return "<img src='/Afficher/Icones/Partner.png' width='48px' title='$texte' class='float-left mx-2' />";}
	if ($place != "adversaire") {
		return "<img src='/Afficher/Icones/Partner.png' width='16px' title='$texte' />";
	}
}

function afficheHash ($id) {
	$sql =	"SELECT hash ".//
			"FROM decks " . //
			"WHERE id_discord = $id " . //
				"AND est_joue = 1;";
	return "<span style='font-weight:normal'><i>" . executerRequete($sql)->fetchColumn() . "</i></span>";
}
