<?php

function Affichage ($helper) {
	$affichage = "";
	for ($i = 0; $i < count($helper['infos']['groupes']); $i++) {
		$groupe = $helper['infos']['groupes'][$i];
		$infos = $helper['groupe'][$groupe];

		$affichage .= afficheGroupe($groupe,$infos);
	}
	return $affichage;
}
