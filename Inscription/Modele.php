<?php
/*****************************
 *                           *
 * CONTRÔLE DES INSCRIPTIONS *
 *                           *
 *****************************/
function dejaInscrit ($id_discord = "") {
	if ($id_discord != "") {
		// On va executer la requete de vérification
		$sql = "SELECT COUNT(*) FROM participants WHERE id_discord = $id_discord;";
		$requete = executerRequete($sql);
		// On va regarder le résultat
		if ($requete->fetchColumn() > 0) { return 'e101'; }
		return 'XXX';
	}
	return '001';
}

function dropPrecedent ($id_discord = "") {
	if ($id_discord != "") {
		// On va executer la requete de vérification
		$sql = "SELECT COUNT(*) FROM participants WHERE id_discord LIKE '%$id_discord%';";
		$requete = executerRequete($sql);
		// On va regarder le résultat
		if ($requete->fetchColumn() > 0) { return 'e101'; }
		return 'XXX';
	}
	return '001';
}

/*****************************
 *                           *
 * FONCTION D'AJOUT DE DECK  *
 *                           *
 *****************************/
function ajoutDeck ($parametres) {
	/***** Champs de la table decks
	@(id_deck), id_joueur, est_joue, cle_MV, hash, liste, general
	*****/
	$sql = "INSERT INTO `decks` (id_discord,est_joue,cle_MV,hash,liste,general)".//
						"VALUES (:id_discord, :est_joue, :cle_MV, :hash, :liste, :general);";

	$deck = array(
		':id_discord'	=>	$parametres['id'],
		':est_joue'		=>	1,
		':cle_MV'		=>	$parametres['liste'],
		':hash'			=>	$parametres['hash'],
		':liste'		=>	getListeJSON($parametres['liste']),
		':general'		=>	getGeneralJSON($parametres['liste'])
	);

	$requete = executerRequete($sql,$deck);
	return false;
}

/*****************************
 *                           *
 *  TRAITEMENT DES DECKLISTS *
 *     DEPUIS MAGIC-VILLE    *
 *                           *
 *****************************/
function getListeJSON ($id) {
	return json_encode(getListe($id)['deck']);
}

function getGeneralJSON ($id) {
	return json_encode(getListe($id)['general']);
}

function getListe ($id) {
	$liste = file_get_contents_utf8("https://magic-ville.fr/fr/decks/dl_appr.php?ref=".$id);
	$liste = preg_split('/<br>/i', $liste, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE)[0];
	return listeMVtoArray($liste);
}

function listeMVtoArray ($decklist) {
	// Variable de stockage de la decklist
	$deck = array(
		'deck'		=> array(),
		'general'	=> array()
	);

	// On sépare la deckliste en lignes
	$lignes = preg_split("/<br \/>/",$decklist);

	// On agit individuellement sur chaque ligne
	for ($ligne = 1; $ligne < (count($lignes) - 1); $ligne++) {
		ajouterLigneAuDeck($lignes[$ligne], $deck);
	}

	// On fait un tri par ordre alphabétique des éléments du deck
	$deck['general'] = triAlphabetiqueParNom($deck['general']);
	$deck['deck'] = triAlphabetiqueParNom($deck['deck']);

	return $deck;
}

function ajouterLigneAuDeck ($ligne, &$tableau) {
	$depart = 0; // Position de l'info 'quantité'
	$nom = array();

	// On traite la ligne comme un tableau ayant pour séparateur " "
	$ligne = preg_split('/ +/i',$ligne);

	// Si le test est réussi, c'est que c'est une carte de side, on décale le départ
	if (!is_numeric($ligne[0])) { $depart++; }

	// $i = $depart => quantité

	// On remet tout le reste dans le nom de la carte
	for ($i = ($depart + 1); $i < count($ligne); $i++) {
		$nom[] = $ligne[$i];
	}
	$nom = join(" ",$nom);

	$zone = ($depart == 0) ? 'deck' : 'general';
	$tableau[$zone][] = array(
		'qte' => $ligne[$depart]*1,
		'nom' => $nom
	);
}

function triAlphabetiqueParNom ($liste) {
	if (count($liste) < 2) { return $liste; }

	for ($j = 0; $j < count($liste); $j++) {
		for ($i = 1; $i < count($liste); $i++) {
			if (strcmp($liste[$i-1]['nom'],$liste[$i]['nom']) > 0) {
				$tampon = $liste[$i-1];
				$liste[$i-1] = $liste[$i];
				$liste[$i] = $tampon;
			}
		}
	}
	return $liste;
}
