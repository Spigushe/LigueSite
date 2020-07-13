<?php
// $parametres['page'] = 'Inscription'

if (isset($parametres['action']) && ($parametres['action'] != "")) {
	switch ($parametres['action']) {
		case 'Ajouter':
			require_once $parametres['page']."/".$parametres['action'].".php";
			echo nouveauResultat($parametres);
			break;
		default:
			$titre_page = " - Accueil";
			$contenu = "";
			include('Vue.php');
			break;
	}
}
