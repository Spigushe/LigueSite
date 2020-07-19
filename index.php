<?php
session_start();
// Numéro de la saison en cours
define('__SAISON__',3);
// Est-on en Playoffs ?
define('__PLAYOFF__',1);
// Nombre max de matches par saison
define('__MAX_MATCHES__',1);

/** Utilisation du modèle MVC
 * Page contrôleur simple
 */

$parametres = array_merge($_GET,$_POST);

/* ROUTAGE DE LA REQUETE */
require_once 'Controleur.php';
