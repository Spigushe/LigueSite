<?php
/* APPEL DES FICHIERS STRUCTURANTS */
require_once('Modele.php');


if  (isset($parametres['page']) && ($parametres['page'] != "")) {
	require_once($parametres['page'].'/Modele.php');
	require_once($parametres['page'].'/Controleur.php');
} else {
	require_once('Afficher/Modele.php');
	require_once('Afficher/Controleur.php');
	require_once('Afficher/Vue.php');
}