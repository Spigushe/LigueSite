<?php
require_once("Afficher/Elements/Tableaux/Vue_TableauClassement.php");

function afficherTableauClassement ($helper) {
	$retour  = "<h3 class='mt-3'>Classement au sein de la poule</h3>";
	$retour .= tableauClassement($helper);
	$retour .= "<div class='my-5'></div>";

	return $retour;
}
