<?php
function infosParticipant (&$joueur)
{
	$sql = "SELECT * FROM participants WHERE pseudo LIKE :pseudo;";
	$donnees = array(':pseudo'=>$joueur['pseudo']);
	$requete = executerRequete($sql,$donnees);
	$resultat = $requete->fetch();

	if(count($resultat) == 0) {
		return true; // Il y a un problème
	}

	$joueur['id'] = $resultat['id_discord'];
	$joueur['ligue'] = $resultat['nom_role'];
	$joueur['elo'] = $resultat['elo'];

	return false; // Il n'y a pas de problème
}

function deckParJoueur ($id_discord)
{
	// On va chercher si le joueur existe
	$sql = "SELECT id_deck FROM decks WHERE id_discord = :id AND est_joue = 1;";
	$resultat = executerRequete($sql,array(':id'=>$id_discord))->fetchColumn();
	// Traitement du retour
	if ($resultat != "")
	{
		return $resultat;
	}
	return 'e105';
}

function nombreMatches ($joueur1, $joueur2)
{
	$sql = "SELECT COUNT(id_resultat) FROM resultats WHERE " . //
			"((id_deck1 = :id1 AND id_deck2 = :id2) OR " .//
			"(id_deck1 = :id2 AND id_deck2 = :id1)) AND " .//
			"ligue = :ligue AND saison = :saison;";

	// Vérification de la saison
	$saison = __SAISON__;
	if ($joueur1['ligue'] == 'Placements')
	{
		$saison = $saison + 1;
	}

	//
	$donnees = array(
		':id1'		=> $joueur1['deck'],
		':id2'		=> $joueur2['deck'],
		':ligue'	=> $joueur1['ligue'],
		':saison'	=> $saison
	);
	// Execution de la requete
	$requete = executerRequete($sql,$donnees);

	// Retour du nombre de matches
	return $requete->fetch()['COUNT(id_resultat)'];
}

function ajouterResultat ($joueur1, $joueur2)
{
	// Requete SQL
	$sql =	"INSERT INTO resultats (id_deck1,resultat_deck1,id_deck2,resultat_deck2,ligue,saison) ".//
						"VALUES (:id_deck1,:resultat_deck1,:id_deck2,:resultat_deck2,:ligue,:saison);";

	executerRequete($sql,
		array(
			':id_deck1'			=> $joueur1['deck'],
			':resultat_deck1'	=> $joueur1['resultat'],
			':id_deck2'			=> $joueur2['deck'],
			':resultat_deck2'	=> $joueur2['resultat'],
			':ligue'			=> $joueur1['ligue'],
			':saison'			=> $joueur1['saison']
		)
	);

	modificationElo($joueur1);
	modificationElo($joueur2);

	// Retour de la fonction : la ligue
	return "OK--" . $joueur1['ligue'];
}

function eloJoueur ($id_joueur)
{
	$sql = "SELECT elo FROM participants WHERE id_discord LIKE :id;";
	$donnees = array(':id'=>$id_joueur);
	return executerRequete($sql,$donnees)->fetch();
}

function modificationElo ($joueur)
{
	$sql = "UPDATE participants SET elo = :elo WHERE id_discord = :id;";
	$donnees = array(
		':elo' => $joueur['elo'],
		':id' => $joueur['id'],
	);
	executerRequete($sql,$donnees);
}
