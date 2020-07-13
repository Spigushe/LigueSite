<?php
require_once "Afficher/Elements/Tableaux/Vue_TableauParties.php";

function afficherTableauParties ($helper) {
	$retour  = "<h3 class='mt-3'>Résumé des parties</h3>";
	$retour .= tableauParties($helper);
	$retour .= "<div class='my-5'></div>";

	return $retour;
}
