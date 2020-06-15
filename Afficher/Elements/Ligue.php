<?php
// Fonctions annexes
require_once('Afficher/Elements/Modele.php');
require_once('Afficher/Elements/Ligue/Modele.php');
// Helper
require_once("Afficher/Elements/Ligue/Resultats.php");

function Affichage ($helper) {
	$affichage  = "<div class='my-5'></div>";
	$affichage .= progressLigue($helper);
	$affichage .= "<div class='my-5'></div>";
	$affichage .= "<h3 class='mt-3'>Résultats et informations</h3>";
	$affichage .= tableauJoueurs($helper);
	$affichage .= "<div class='my-5'></div>";
	$affichage .= "<h3 class='mt-3'>Résultat des parties</h3>";
	$affichage .= "<p class='mb-2'><i>You might have to scroll horizontally to access everything</i></p>";
	$affichage .= tableauResultats ($helper);

	return $affichage;
}
