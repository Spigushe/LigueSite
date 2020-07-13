<?php
/*****************************/
/*****************************/
/******                 ******/
/******      BARRES     ******/
/******                 ******/
/*****************************/
/*****************************/
require_once 'Afficher/Elements/Barres/BarreAvancement.php';
require_once 'Afficher/Elements/Barres/BarreJoueur.php';

/*****************************/
/*****************************/
/******                 ******/
/******     TABLEAUX    ******/
/******                 ******/
/*****************************/
/*****************************/
require_once 'Afficher/Elements/Tableaux/TableauResultats.php';
require_once 'Afficher/Elements/Tableaux/TableauMetagame.php';
require_once 'Afficher/Elements/Tableaux/TableauParties.php';
require_once 'Afficher/Elements/Tableaux/TableauClassement.php';

/*****************************/
/*****************************/
/******                 ******/
/******     GENERAL     ******/
/******                 ******/
/*****************************/
/*****************************/
function imageCompagnon ($texte = "") {
	return "<img src='/Afficher/Icones/Companion.png' width='16px' title='$texte'  />";
}

function imagePartenaires ($place = "" , $texte = "") {
	if ($place == "principal") {
		return "<img src='/Afficher/Icones/Partner.png' width='48px' title='$texte' class='float-left mx-2' />";}
	if ($place != "adversaire") {
		return "<img src='/Afficher/Icones/Partner.png' width='16px' title='$texte' />";
	}
}
