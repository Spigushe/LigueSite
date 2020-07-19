<?php
// Affichage selon niveau de profondeur
if (preg_match("/-/",__LIGUE__)) {
	require_once "Afficher/Elements/Vue/Vue_Poule.php";
} else {
	require_once "Afficher/Elements/Vue/Vue_Placement.php";
}
