<?php
function Affichage ($helper) {
	$affichage  = afficherTableauMetagame ($helper);
	$affichage .= afficherTableauParties ($helper);
	
	return $affichage;
}
