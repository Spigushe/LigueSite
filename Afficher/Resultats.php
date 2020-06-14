<?php
// On prépare les variables de base
$saison = $parametres['saison'];
$ligue  = $parametres['ligue'];

// Liste des decks dans saison et ligue
$sql = "SELECT liste_decks FROM ligues WHERE nom_ligue LIKE :l AND num_saison LIKE :s;";
$donnees = array(
	':l' => $ligue,
	':s' => $saison
);
$liste = preg_split('/, /i',executerRequete($sql,$donnees)->fetchColumn());

// Informations concernant les decks dans la liste
$sql2 = "SELECT * FROM decks d " . //
	"JOIN participants p ON d.id_discord = p.id_discord " . //
	"WHERE d.id_deck = :id";

for ($i = 0; $i < count($liste); $i++) {
	$requete = executerRequete($sql2,array(':id'=>$liste[$i]));
	$decks[$liste[$i]] = $requete->fetch();
}

// Table des résultats selon liste
$sql3 = "SELECT * FROM resultats WHERE " . //
	"((id_deck1 = :id1 AND id_deck2 = :id2) OR (id_deck1 = :id2 AND id_deck2 = :id1)) " . //
	"AND ligue = :l AND saison = :s;";

for ($i = 1; $i < count($liste); $i++) {
	$donnees[':id1'] = $liste[$i];
	for ($j = 0; $j < $i; $j++) {
		$parties[$liste[$i]][$liste[$j]] = array();
		$parties[$liste[$j]][$liste[$i]] = array();
		$donnees[':id2'] = $liste[$j];
		$requete = executerRequete($sql3,$donnees);
		while ($resultat = $requete->fetch()) {
			$parties[$liste[$i]][$liste[$j]][] = array(
				'player'	=> $resultat['id_deck1'],
				'p_discord'	=> $decks[$resultat['id_deck1']]['id_discord'],
				'p_pseudo'	=> $decks[$resultat['id_deck1']]['pseudo'],
				'opponent'	=> $resultat['id_deck2'],
				'o_discord'	=> $decks[$resultat['id_deck2']]['id_discord'],
				'o_pseudo'	=> $decks[$resultat['id_deck2']]['pseudo'],
				'score'		=> $resultat['resultat_deck1']." - ".$resultat['resultat_deck2'],
				'final_r'	=> ($resultat['resultat_deck1'] > $resultat['resultat_deck2']) ? "win" : "lose",
				'p_result'	=> $resultat['resultat_deck1'],
				'p_deck'	=> $resultat['id_deck1'],
				'p_list'	=> $decks[$resultat['id_deck1']]['liste'],
				'p_com'		=> $decks[$resultat['id_deck1']]['general'],
				'p_hash'	=> $decks[$resultat['id_deck1']]['hash'],
				'o_result'	=> $resultat['resultat_deck2'],
				'o_deck'	=> $resultat['id_deck2'],
				'o_list'	=> $decks[$resultat['id_deck2']]['liste'],
				'o_com'		=> $decks[$resultat['id_deck2']]['general'],
				'o_hash'	=> $decks[$resultat['id_deck2']]['hash'],
			);
			$parties[$liste[$j]][$liste[$i]][] = array(
				'player'	=> $resultat['id_deck2'],
				'p_discord'	=> $decks[$resultat['id_deck2']]['id_discord'],
				'p_pseudo'	=> $decks[$resultat['id_deck2']]['pseudo'],
				'opponent'	=> $resultat['id_deck1'],
				'o_discord'	=> $decks[$resultat['id_deck1']]['id_discord'],
				'o_pseudo'	=> $decks[$resultat['id_deck1']]['pseudo'],
				'score'		=> $resultat['resultat_deck2']." - ".$resultat['resultat_deck1'],
				'final_r'	=> ($resultat['resultat_deck2'] > $resultat['resultat_deck1']) ? "win" : "lose",
				'p_result'	=> $resultat['resultat_deck2'],
				'p_deck'	=> $resultat['id_deck2'],
				'p_list'	=> $decks[$resultat['id_deck2']]['liste'],
				'p_com'		=> $decks[$resultat['id_deck2']]['general'],
				'p_hash'	=> $decks[$resultat['id_deck2']]['hash'],
				'o_result'	=> $resultat['resultat_deck1'],
				'o_deck'	=> $resultat['id_deck1'],
				'o_list'	=> $decks[$resultat['id_deck1']]['liste'],
				'o_com'		=> $decks[$resultat['id_deck1']]['general'],
				'o_hash'	=> $decks[$resultat['id_deck1']]['hash'],
			);
		}
	}
}
