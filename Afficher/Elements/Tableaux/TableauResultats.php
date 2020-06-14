<div class="table-responsive">
<table id="tableMatches" class="table table-hover" aria-describedby="tableMatches">
	<!--<caption>Résultats des parties</caption>-->
	<thead>
		<tr>
			<th scope="col" class="sorting" aria-controls="tablePlacements"></th>
		<?php
		for ($i = 0; $i < (count($infos)-1); $i++) {
			?>
			<th scope="col" class="text-center"><?= $infos[$i]['pseudo'] ?><!--<br><?= afficheHash($infos[$i]['id_discord']) ?>--></th>
			<?php
			}
		?>
		</tr>
	</thead>
	<tbody>
	<?php
	for ($i = 1; $i < count($infos); $i++) {
		?>
		<tr>
			<td scope="row" class="align-middle">
				<strong><?= $infos[$i]['pseudo'] ?></strong>
				<!--<br><?= afficheGeneral($infos[$i]['general'], 'resultat') ?>-->
			</td>
			<?php for ($j = 0; $j < $i; $j++) : ?>
				<td class='align-middle text-center'>
					<?= getResultatPartie($infos[$i],$infos[$j]) ?>
				</td>
			<?php endfor; ?>
		</tr>
		<?php
	}
	?>
	</tbody>
</table>
</div>

<?php
function getResultatPartie ($id_deck1, $id_deck2) {
	$partie = getPartie($id_deck1, $id_deck2);
	return "<strong>".$partie['vainqueur']."</strong><br><i>".$partie['score']."</i>";
}

function getPartie ($info_j1, $info_j2) {
	if ($_GET['saison'] == 1) {
		$resultats = "resultats_saison1";
	} else {
		$resultats = "resultats";
	}
	$sql =	"SELECT " . //
				"$resultats.id_deck1, " . //
				"$resultats.resultat_deck1, " . //
				"$resultats.resultat_deck2 " . //
			"FROM $resultats " . //
			"WHERE " . //
				"(id_deck1 = :j1 AND id_deck2 = :j2) " . //
				"OR " . //
				"(id_deck1 = :j2 AND id_deck2 = :j1) " . //
			"ORDER BY $resultats.id_resultat DESC;";


	try {
		$resultat = executerRequete($sql,
			array(
				':j1' => $info_j1['id_deck'],
				':j2' => $info_j2['id_deck']
			)
		)->fetch();

		$j1 = ($resultat['id_deck1'] == $info_j1['id_deck']) ? 'j1' : '' ;

		if ($resultat['resultat_deck1'] > $resultat['resultat_deck2']) {
			return array(
				'vainqueur'	=> ($j1 == 'j1') ? $info_j1['pseudo'] : $info_j2['pseudo'],
				'score'		=> $resultat['resultat_deck1'] . ' - ' . $resultat['resultat_deck2']
			);
		} else if ($resultat['resultat_deck2'] > $resultat['resultat_deck1']) {
			return array(
				'vainqueur'	=> ($j1 == 'j1') ? $info_j2['pseudo'] : $info_j1['pseudo'],
				'score'		=> $resultat['resultat_deck2'] . ' - ' . $resultat['resultat_deck1']
			);
		}
	} catch (PDOException $e) {
		return array('vainqueur'=>'','score'=>'Erreur');
	}

	return array('vainqueur'=>'','score'=>'Partie à jouer');
	//*/
}
?>
