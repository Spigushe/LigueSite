<?php
// Récupère la saison en cours
$sql = "SELECT num_saison FROM ligues WHERE nom_ligue NOT LIKE '%Placement%' ORDER BY num_saison DESC;";
$saison = executerRequete($sql)->fetchColumn();

// On récupère la liste des ligues dans la saison
$sql = "SELECT nom_ligue FROM ligues WHERE num_saison = $saison AND nom_ligue NOT LIKE '%Placement%' AND nom_ligue NOT LIKE '%Playoff%';";
$requete = executerRequete($sql);
$ligues = array();
while ($resultat = $requete->fetch()) {
	$ligues[] = $resultat['nom_ligue'];
}

// On récupère la liste des decks dans chaque ligue
$sql = "SELECT liste_decks FROM ligues WHERE num_saison = $saison AND nom_ligue = :l;";
for ($i = 0; $i < count($ligues); $i++) {
	$requete = executerRequete($sql,array(':l'=>$ligues[$i]));
	$resultat = $requete->fetch()['liste_decks'];
	$liste[$ligues[$i]] = preg_split("/, /i",$resultat);
}

// On compte le nombre de matches dans bdd pour ligue et saison
$sql = "SELECT COUNT(id_resultat) FROM resultats WHERE saison = $saison AND ligue = :l ";
$sql = $sql . "AND ((id_deck1 = :id1 AND id_deck2 = :id2) OR (id_deck1 = :id2 AND id_deck2 = :id1));";


// ligues
for ($i = 0; $i < count($ligues); $i++) {
	$ligue[$ligues[$i]] = array(
		'ligue'		=> $ligues[$i],
		'listes'	=> $liste[$ligues[$i]],
		'max'		=> (count($liste[$ligues[$i]]) * (count($liste[$ligues[$i]])-1)) / 2,
		'actuels'	=> 0,
	);

	// Resultats
	for ($j = 1; $j < count($liste[$ligues[$i]]); $j++) {
		for ($k = 0; $k < $j; $k++) {
			$donnees = array(
				':l' => $ligue[$ligues[$i]]['ligue'],
				':id1' => $ligue[$ligues[$i]]['listes'][$j],
				':id2' => $ligue[$ligues[$i]]['listes'][$k],
			);

			$retour = executerRequete($sql,$donnees)->fetch()['COUNT(id_resultat)'];
			$ligue[$ligues[$i]]['actuels'] += $retour;
		}
	}
}

$parties = $ligue;
