<?php

function Affichage ($helper) {
	$affichage = "";

	for ($i = 0; $i < count($helper['infos']['groupes']); $i++) {
		$groupe = $helper['infos']['groupes'][$i];
		if ((__PLAYOFF__ == 1) && (!preg_match("/Playoff/i",$groupe))) {
			continue;
		}
		$infos = $helper['groupe'][$groupe];

		$affichage .= afficheGroupe($groupe,$infos);
	}
	return $affichage;
}
