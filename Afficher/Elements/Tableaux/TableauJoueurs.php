<?php
require_once("Afficher/Elements/Tableaux/Vue_TableauJoueurs.php");

function afficherTableauJoueurs ($helper) {
	$retour  = "<h3 class='mt-3'>Résultats et informations</h3>";
	$retour .= tableauJoueurs($helper);
	$retour .= "<div class='my-5'></div>";

	return $retour;
}
