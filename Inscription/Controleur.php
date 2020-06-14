<?php
// $parametres['page'] = 'Inscription'

if (isset($parametres['action']) && ($parametres['action'] != "")) {
	switch ($parametres['action']) {
		case 'Ajouter':
			require_once($parametres['page']."/".$parametres['action'].".php");
			echo nouveauParticipant($parametres);
			break;
		case 'Changer':
			require_once($parametres['page']."/".$parametres['action'].".php");
			echo changementDeck($parametres);
			break;
		case 'GiveUp':
			require_once($parametres['page']."/".$parametres['action'].".php");
			echo mettreEnPause($parametres);
			break;
		case 'Drop':
			require_once($parametres['page']."/".$parametres['action'].".php");
			echo dropJoueur($parametres);
			break;
		case 'Corriger':
			require_once($parametres['page']."/".$parametres['action'].".php");
			echo corrigerDeck($parametres);
			break;
		case 'Liste':
			require_once($parametres['page']."/".$parametres['action'].".php");
			echo listeLigue($parametres);
			break;
		case 'Retrieve':
			require_once($parametres['page']."/".$parametres['action'].".php");
			echo envoyerListe($parametres);
			break;
		default:
			$titre_page = " - Accueil";
			$contenu = "";
			include('Vue.php');
			break;
	}
}
