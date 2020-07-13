<?php

if (preg_match("/-/",$_GET['ligue'])) {
	require_once "Afficher/Elements/Helpers/Details.php";
} else {
	require_once "Afficher/Elements/Helpers/Groupe.php";
}
