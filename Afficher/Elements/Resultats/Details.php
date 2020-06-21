<?php
/****** Objectif ******
Avoir un tableau global qui reprend toutes les infos d'une ligue et d'une saison
- Informations générales
	|- Liste des decks
	|- Liste des pseudos
	|- Liste des id_discord
	|- Nombre de decks
	|- Nombre de matches joués
	|- Nombre de matches au total
	|- Saison
	|- Ligue
- Liste des joueurs (accessible via le pseudo ou l'id_deck)
	|- Pseudo
	|- Id_Discord
	|- Id_Deck
	|- Hash du deck
	|- Liste du deck
	|- Général
- Liste des résultats
	|- Access transposé
		\ Resultat(Joueur1)(Joueur2) = Resultat[^(-1)](Joueur2)(Joueur1)
			\ Joueur = Pseudo / Id_Discord / Id_Deck
	|- Id des decks
	|- Résultats brut
	|- String d'affichage du résultat
	|- Win ou Lose
	|- Infos du vainqueur (pseudo / id_discord / id_deck)
 ******   Fin    ******/

$helper = array(); /** VARIABLE DE STOCKAGE **/

/*****************************/
/*****************************/
/******                 ******/
/****** LISTE DES DECKS ******/
/******                 ******/
/*****************************/
/*****************************/
$sql = "SELECT liste_decks FROM ligues
		WHERE num_saison = :s AND nom_ligue = :l;";
// On prépare les variables de base
$helper['infos']['saison'] = $_GET['saison'];
$helper['infos']['ligue']  = preg_split("/-/",$_GET['ligue'])[0];
// On prépare le tableau de données
$donnees = array(
	':l' => $_GET['ligue'],
	':s' => $helper['infos']['saison'],
);
// On exécute la requête
$requete = executerRequete($sql,$donnees);
$resultat = $requete->fetch()['liste_decks'];
// Liste des decks
$_liste = preg_split('/, /i',$resultat);
$helper['infos']['decks'] = $_liste;
// Nombre de matches au total
$_nbDecks = count($helper['infos']['decks']);
$helper['infos']['nbDecks'] = $_nbDecks;
$helper['infos']['max'] = $_nbDecks * ($_nbDecks - 1) / 2;
$helper['infos']['joues'] = 0;

/*****************************/
/*****************************/
/******                 ******/
/******  INFOS JOUEURS  ******/
/******                 ******/
/*****************************/
/*****************************/
$sql = "SELECT * FROM participants p
		JOIN decks d ON p.id_discord = d.id_discord
		WHERE d.id_deck = :id;";
// On parcourt la liste
for ($i = 0; $i < count($helper['infos']['decks']); $i++) {
	$requete = executerRequete($sql,array(':id'=>$helper['infos']['decks'][$i]));
	$resultat = $requete->fetch();
	// On ajoute ces infos au helper
	// Ajouter dans la partie 'infos'
	$helper['infos']['pseudo'][] = $resultat['pseudo'];
	$helper['infos']['id_discord'][] = $resultat['id_discord'];
	// Ajouter dans la partie "détaillée"
	// Par Pseudo
	$helper[$resultat['id_deck']] = array(
		'pseudo'		=> $resultat['pseudo'],
		'id_discord'	=> $resultat['id_discord'],
		'id_deck'		=> $resultat['id_deck'],
		'liste'			=> $resultat['liste'],
		'general'		=> $resultat['general'],
		'hash'			=> $resultat['hash'],
		'parties'		=> array(), /* On y stockera les matches */
		'victoires'		=> 0,
		'defaites'		=> 0,
	);
}

/*****************************/
/*****************************/
/******                 ******/
/******  INFOS PARTIES  ******/
/******                 ******/
/*****************************/
/*****************************/
$sql = "SELECT * FROM resultats r
		JOIN decks d ON d.id_deck = r.id_deck1
		WHERE r.id_deck1 = :id AND
		saison = :s AND ligue = :l;";
$donnees = array(
	':s' => $helper['infos']['saison'],
	':l' => $helper['infos']['ligue'],
);
// On parcourt les decks
for ($i = 0; $i < count($helper['infos']['decks']); $i++) {
	$donnees[':id'] = $helper['infos']['decks'][$i];
	$requete = executerRequete($sql,$donnees);
	while ($resultat = $requete->fetch()) {
		$id1 = $resultat['id_deck1'];
		$id2 = $resultat['id_deck2'];
		// Joueur 1 - Id_Deck
		$helper[$id1]['parties'][$id2] = array(
			'p_result'	=> $resultat['resultat_deck1'],
			'p_deck'	=> $resultat['id_deck1'],
			'o_result'	=> $resultat['resultat_deck2'],
			'o_deck'	=> $resultat['id_deck2'],
			'o_pseudo'	=> $helper[$resultat['id_deck2']]['pseudo'],
			'string'	=> $resultat['resultat_deck1'] . " - " . $resultat['resultat_deck2'],
			'result'	=>
				($resultat['resultat_deck1'] > $resultat['resultat_deck2']) ?
					'win' : 'lose',
			'w_deck'	=>
				($resultat['resultat_deck1'] > $resultat['resultat_deck2']) ?
					$resultat['id_deck1'] : $resultat['id_deck2'],
			'w_pseudo'	=>
				($resultat['resultat_deck1'] > $resultat['resultat_deck2']) ?
					$helper[$resultat['id_deck1']]['pseudo'] :
					$helper[$resultat['id_deck2']]['pseudo'],
			'w_discord'	=>
				($resultat['resultat_deck1'] > $resultat['resultat_deck2']) ?
					$helper[$resultat['id_deck1']]['id_discord'] :
					$helper[$resultat['id_deck2']]['id_discord'],
			'w_general' =>
				($resultat['resultat_deck1'] > $resultat['resultat_deck2']) ?
					$helper[$resultat['id_deck1']]['general'] :
					$helper[$resultat['id_deck2']]['general'],
		);
		// Joueur 2 - Id_Deck
		$helper[$id2]['parties'][$id1] = array(
			'p_result'	=> $resultat['resultat_deck2'],
			'p_deck'	=> $resultat['id_deck2'],
			'o_result'	=> $resultat['resultat_deck1'],
			'o_deck'	=> $resultat['id_deck1'],
			'o_pseudo'	=> $helper[$resultat['id_deck1']]['pseudo'],
			'string'	=> $resultat['resultat_deck2'] . " - " . $resultat['resultat_deck1'],
			'result'	=> ($resultat['resultat_deck2'] > $resultat['resultat_deck1']) ?
					'win' : 'lose',
			'w_deck'	=>
				($resultat['resultat_deck2'] > $resultat['resultat_deck1']) ?
					$resultat['id_deck2'] : $resultat['id_deck1'],
			'w_pseudo'	=>
				($resultat['resultat_deck2'] > $resultat['resultat_deck1']) ?
					$helper[$resultat['id_deck2']]['pseudo'] :
					$helper[$resultat['id_deck1']]['pseudo'],
			'w_discord'	=>
				($resultat['resultat_deck2'] > $resultat['resultat_deck1']) ?
					$helper[$resultat['id_deck2']]['id_discord'] :
					$helper[$resultat['id_deck1']]['id_discord'],
			'w_general' =>
				($resultat['resultat_deck2'] > $resultat['resultat_deck1']) ?
					$helper[$resultat['id_deck2']]['general'] :
					$helper[$resultat['id_deck1']]['general'],
		);
		// Répartition des infos
		// Pseudo
		$cle1 = $helper[$id1]['pseudo'];
		$cle2 = $helper[$id2]['pseudo'];
		$helper[$id1]['parties'][$cle2] = $helper[$id1]['parties'][$id2];
		$helper[$id2]['parties'][$cle1] = $helper[$id2]['parties'][$id1];
		// Id_Discord
		$cle1 = $helper[$id1]['id_discord'];
		$cle2 = $helper[$id2]['id_discord'];
		$helper[$id1]['parties'][$cle2] = $helper[$id1]['parties'][$id2];
		$helper[$id2]['parties'][$cle1] = $helper[$id2]['parties'][$id1];
		// Enregistrement des infos complémentaires
		$helper[$id1]['victoires'] +=
			($helper[$id1]['parties'][$id2]['result'] == 'win') ? 1 : 0;
		$helper[$id1]['defaites'] +=
			($helper[$id1]['parties'][$id2]['result'] == 'lose') ? 1 : 0;
		$helper[$id2]['victoires'] +=
			($helper[$id2]['parties'][$id1]['result'] == 'win') ? 1 : 0;
		$helper[$id2]['defaites'] +=
			($helper[$id2]['parties'][$id1]['result'] == 'lose') ? 1 : 0;

		// On comptabilise le match
		$helper['infos']['joues']  += 1;
	}
}

/*****************************/
/*****************************/
/******                 ******/
/******  TRANSPOSITION  ******/
/******                 ******/
/*****************************/
/*****************************/
foreach (array_keys($helper) as $cle) {
	// On va copier les infos du tableau
	if ($cle != 'infos') {
		// Par pseudo
		$pseudo = $helper[$cle]['pseudo'];
		$helper[$pseudo] = $helper[$cle];
		// Par id_discord
		$discord = $helper[$cle]['id_discord'];
		$helper[$discord] = $helper[$cle];
	}
}

/*****************************/
/*****************************/
/******                 ******/
/******  TRI PAR PSEUDO ******/
/******                 ******/
/*****************************/
/*****************************/
sort($helper['infos']['pseudo']);
