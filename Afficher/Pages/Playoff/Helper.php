<?php
// Helper selon niveau de profondeur
if (preg_match("/-/",__LIGUE__)) {
	require_once "Afficher/Elements/Helpers/Details.php";
} else {
	require_once "Afficher/Elements/Helpers/Groupe.php";
}
