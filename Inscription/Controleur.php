<?php
// $parametres['page'] = 'Inscription'

if (isset($parametres['action']) && ($parametres['action'] != "")) {
	switch ($parametres['action']) {
		case 'Ajouter':
			require_once("Inscription/Ajouter.php");
			break;
		case 'Drop':
			require_once("Inscription/Drop.php");
			break;
		case 'Pause':
			require_once("Inscription/Pause.php");
			break;
	}
	Action($parametres);
}
