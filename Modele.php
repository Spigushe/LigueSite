<?php
require_once("BD/dicoTables.php");
require_once("BD/dicoErreurs.php");

function getBdd() {
	// Création de la connexion
	$bdd = new PDO("sqlite:BD/database.sqlite");
	    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// Vérification de l'existence des tables
	$bdd->query($_SESSION['dicoTables']['tableParticipants']);
	$bdd->query($_SESSION['dicoTables']['tableRoles']);
	$bdd->query($_SESSION['dicoTables']['tableDecks']);
	$bdd->query($_SESSION['dicoTables']['tableResultats']);
	$bdd->query($_SESSION['dicoTables']['tableLigues']);
	// On passe la connexion à la base de données
	return $bdd;
}

function executerRequete($sql, $params = null) {
	if ($params == null) {
		$resultat = getBdd()->query($sql);   // exécution directe
	} else {
		$resultat = getBdd()->prepare($sql); // requête préparée
		$resultat->execute($params);
	}
	return $resultat;
}

function file_get_contents_utf8($fn) {
     $content = file_get_contents($fn);
      return mb_convert_encoding($content, 'UTF-8',
          mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
}