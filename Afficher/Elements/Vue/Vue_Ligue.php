<?php
function Affichage ($helper) {
	$affichage  = progressLigue($helper);
	$affichage .= afficherTableauJoueurs($helper);
	$affichage .= afficherTableauResultats($helper);

	return $affichage;
}
