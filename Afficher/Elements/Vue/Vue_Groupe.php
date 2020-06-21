<?php
function Affichage ($helper) {
	$affichage = "<h3 class='mt-3'>Détail du metagame</h3>";
	$affichage .= afficherTableauMetagame ($helper);
	$affichage .= "<div class='my-5'></div>";
	$affichage .= "<h3 class='mt-3'>Résumé des parties</h3>";
	$affichage .= afficherTableauParties ($helper);
	$affichage .= "<div class='my-5'></div>";

	return $affichage;
}
