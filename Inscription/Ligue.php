<?php

function Action ($params)
{
	// Est-ce que la ligue existe ?
	if (roleExiste($params['role']) != 'XXX') {
		return $_SESSION['dicoErreurs'][roleExiste($params['role'])];
	}

	// On récupère la liste des joueurs avec ce rôle
	$liste = getJoueursRole($params['role']);

	$retour = "";
	for ($i = 0; $i < count($liste); $i++) {
		if ($retour != "") $retour .= " ";
<<<<<<< HEAD
		$retour .= "\n" . $liste[$i]['pseudo'] . " (" . $liste[$i]['hash'] . ")";
=======
		$retour .= "\n" . $liste[$i]['pseudo'] . "(" . $liste[$i]['hash'] . ")";
>>>>>>> aa598f9ebca785e74f7d39d1ef2dacef86643308
	}

	return $retour;
}
