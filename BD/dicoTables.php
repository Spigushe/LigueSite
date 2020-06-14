<?php
$_SESSION['dicoTables'] = array(
	"tableParticipants"	=>	"CREATE TABLE IF NOT EXISTS participants (".//
								"id_discord		TEXT		PRIMARY KEY,".//
								"pseudo			TEXT		NOT NULL,".//
								"nom_role		TEXT		NOT NULL".//
							");",

	"tableRoles"		=>	"CREATE TABLE IF NOT EXISTS roles (".//
								"id_discord		TEXT		PRIMARY KEY,".//
								"nom_role		TEXT		NOT NULL".//
							");",
							
	"tableDecks"		=>	"CREATE TABLE IF NOT EXISTS decks (".//
								"id_deck		INTEGER		PRIMARY KEY AUTOINCREMENT,".//
								"id_discord		TEXT		NOT NULL,".//
								"saison			TEXT		NULL,".//
								"est_joue		INTEGER		NOT NULL,".//
								"cle_MV			INTEGER		NOT NULL,".//
								"hash			TEXT		NOT NULL,".//
								"liste			TEXT		NOT NULL,".//
								"general		TEXT		NOT NULL".//
							");",
	
	"tableResultats"	=>	"CREATE TABLE IF NOT EXISTS resultats (".//
								"id_resultat	INTEGER		PRIMARY KEY AUTOINCREMENT,".//
								"id_deck1		INTEGER		NOT NULL,".//
								"resultat_deck1	INTEGER		NOT NULL,".//
								"id_deck2		INTEGER		NOT NULL,".//
								"resultat_deck2	INTEGER		NOT NULL".//
							");",
							
	"tableLigues"		=>	"CREATE TABLE IF NOT EXISTS ligues (".//
								"id_ligue		INTEGER		PRIMARY KEY AUTOINCREMENT,".//
								"num_saison		INTEGER		NOT NULL,".//
								"nom_ligue		TEXT		NOT NULL,".//
								"liste_decks	TEXT		NOT NULL".//
							");",
);
	