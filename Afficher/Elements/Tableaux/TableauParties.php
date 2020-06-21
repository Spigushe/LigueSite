<?php
require_once("Afficher/Elements/Tableaux/Vue_TableauParties.php");

function afficherTableauParties ($helper) {
	sort($helper['infos']['pseudo']);
	return tableauParties($helper);
}
