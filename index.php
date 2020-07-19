<?php
// Est-on en Playoffs ?
define('__PLAYOFF__', 1);
// Nombre max de matches par saison
define('__MAX_MATCHES__', 1);

/** Utilisation du modèle MVC
 * Page contrôleur simple
 */
$parametres = array_merge($_GET,$_POST);

// Numéro de la saison en cours
define('__SAISON__', (!isset($parametres['saison']) || ($parametres['saison'] == "")) ? 3 : $parametres['saison'] * 1);
// Ligue en cours
define('__LIGUE__', (!isset($parametres['ligue']) || ($parametres['ligue'] == "")) ? "" : $parametres['ligue']);

/* ROUTAGE DE LA REQUETE */
require_once 'Controleur.php';
