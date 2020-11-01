<?php
require_once "BD/dicoErreurs.php";

function getBdd() {
	// Création de la connexion
	$bdd = new PDO("sqlite:dist/BD/database.sqlite");
	    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// On passe la connexion à la base de données
	return $bdd;
}

function executerRequete($sql, $params = null) {
	if ($params == null) {
		$resultat = getBdd()->query($sql);   // exécution directe
		return $resultat;
	}

	$resultat = getBdd()->prepare($sql); // requête préparée
	$resultat->execute($params);
	return $resultat;
}

function file_get_contents_utf8($file) {
	$content = file_get_contents($file);
	return mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
}
