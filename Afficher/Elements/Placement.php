<?php
// Fonctions annexes
require_once('Afficher/Elements/Modele.php');
require_once('Afficher/Elements/Placement/Modele.php');

// On choisit les bons fichiers
if (preg_match("/[0-9]/",$_GET['ligue'])) {
	require_once("Afficher/Elements/Ligue/Resultats.php"); // Helper
	require_once("Afficher/Elements/Placement/Groupe.php"); // Vue
} else {
	require_once("Afficher/Elements/Placement/Resultats.php"); // Helper
	require_once("Afficher/Elements/Placement/Global.php"); // vue
}
