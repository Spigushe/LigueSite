<?php
// Fonctions annexes
require_once('Afficher/Elements/Modele.php');
require_once('Afficher/Elements/Placement/Modele.php');


if (preg_match("/[0-9]/",$_GET['ligue'])) {
	// Si on veut afficher un groupe de Placement
	
	// On utilise le helper de la ligue
	require_once("Afficher/Elements/Resultats/Details.php");

	// Vue
	require_once("Afficher/Elements/Vue/Vue_Groupe.php");
} else {
	// Helper
	require_once("Afficher/Elements/Resultats/Placement.php");

	// Vue
	require_once("Afficher/Elements/Vue/Vue_Placement.php");
}
