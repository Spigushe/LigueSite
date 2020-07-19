<?php

if (preg_match("/-/",__LIGUE__)) {
	require_once "Afficher/Elements/Helpers/Details.php";
} else {
	require_once "Afficher/Elements/Helpers/Groupe.php";
}
