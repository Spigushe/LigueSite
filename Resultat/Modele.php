<?php
function joueurParPseudo ($pseudo)
{
	if ($pseudo != "") {
		// On va chercher si le joueur existe
		$sql = "SELECT id_discord FROM participants WHERE pseudo LIKE :pseudo;";
		$resultat = executerRequete($sql,array(':pseudo'=>$pseudo))->fetchColumn();
		// Traitement du retour
		if ($resultat != "")
		{
			return $resultat;
		}
		return '002';
	}
	return '001';
}

function getLigue ($id_discord)
{
	$sql = "SELECT nom_role FROM participants WHERE id_discord = :id";
	$resultat = executerRequete($sql,array(':id'=>$id_discord))->fetchColumn();
	// Traitement du retour
	if ($resultat == '')
	{
		return 'e107';
	}
	return $resultat;
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

	// Retour de la fonction : la ligue
	return "OK--" . $joueur1['ligue'];
}
