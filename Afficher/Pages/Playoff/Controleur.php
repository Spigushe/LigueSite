<?php
// Fonctions annexes
require_once('Afficher/Elements/Modele.php');
require_once('Afficher/Pages/Playoff/Modele.php');

if (preg_match("/-/",$_GET['ligue'])) {
	// Si on veut afficher un groupe de Playoff

	// Helper
	require_once("Afficher/Elements/Resultats/Details.php");

	// Affichage
	require_once("Afficher/Elements/Vue/Vue_Poule.php");
} else {
	// Helper
	require_once("Afficher/Elements/Resultats/Placement.php");

	// Vue
	require_once("Afficher/Elements/Vue/Vue_Placement.php");
}
