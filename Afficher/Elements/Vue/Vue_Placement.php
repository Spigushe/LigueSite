<?php

function Affichage ($helper) {
	$affichage = "";
	foreach ($helper['groupe'] as $groupe => $infos) {
		$affichage .= afficheGroupe($groupe,$infos);
	}
	return $affichage;
}
