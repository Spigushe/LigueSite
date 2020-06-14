<?php
// $parametres['page'] = 'Inscription'

if (isset($parametres['action']) && ($parametres['action'] != "")) {
	switch ($parametres['action']) {
		case 'Ajouter':
			require_once($parametres['page']."/".$parametres['action'].".php");
			echo nouveauRole($parametres);
			break;
		case 'Attribuer':
			require_once($parametres['page']."/".$parametres['action'].".php");
			echo attribuerRole($parametres);
			break;
		default:
			$titre_page = " - Accueil";
			$contenu = "";
			include('Vue.php');
			break;
	}
}