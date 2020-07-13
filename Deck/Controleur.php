<?php
// $parametres['page'] = 'Deck'

if (isset($parametres['action']) && ($parametres['action'] != "")) {
	switch ($parametres['action']) {
		case 'Ajouter':
			require_once "Deck/Ajouter.php";
			break;
		default:
			break;
	}
	Action($parametres);
}
