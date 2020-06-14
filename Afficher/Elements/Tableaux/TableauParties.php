<div class="table-responsive mb-5">
<table id="tablePlacements" class="table table-hover" aria-describedby="tablePlacements">
	<!--<caption>Résultats des parties</caption>-->
	<thead>
		<tr>
			<th scope="col" class="sorting" aria-controls="tablePlacements">Pseudo</th>
			<th scope="col">Deck</th>
			<th scope="col">Victoires</th>
			<th scope="col">Défaites</th>
		</tr>
	</thead>
	<tbody>
	<?php
	for ($i = 0; $i < count($infos); $i++) {
		?>
		<tr>
			<th scope="row" class="align-middle"><?php
			if (!isset($resultats[$infos[$i]['pseudo']]['victoires'])) $victoires = 0;
				else $victoires = min(3,count($resultats[$infos[$i]['pseudo']]['victoires']));
			echo "<img src=\"Afficher/Icones/Placement-".$victoires.".png\" width='32px'>";
			echo $infos[$i]['pseudo'];
			?></th>
			<td class="align-middle sorting_1"><?= afficheGeneral($infos[$i]['general'],'principal') ?></td>
			<td class="align-middle">
			<?php
			if (isset($resultats[$infos[$i]['pseudo']]['victoires'])) {
				for ($j = 0; $j < count($resultats[$infos[$i]['pseudo']]['victoires']); $j++) {
					echo	" [" . $resultats[$infos[$i]['pseudo']]['victoires'][$j]['resultat'] . "] " . //
							$resultats[$infos[$i]['pseudo']]['victoires'][$j]['joueur'] . //
							" (" . //
								afficheGeneral($resultats[$infos[$i]['pseudo']]['victoires'][$j]['general'],'adversaire') . //
							")<br>";
				}
			}
			?>
			</td>
			<td class="align-middle">
			<?php
			if (isset($resultats[$infos[$i]['pseudo']]['defaites'])) {
				for ($j = 0; $j < count($resultats[$infos[$i]['pseudo']]['defaites']); $j++) {
					echo	" [" . $resultats[$infos[$i]['pseudo']]['defaites'][$j]['resultat'] . "] " . //
							$resultats[$infos[$i]['pseudo']]['defaites'][$j]['joueur'] . //
							" (" . //
								afficheGeneral($resultats[$infos[$i]['pseudo']]['defaites'][$j]['general'],'adversaire') . //
							")<br>";
				}
			}
			?>
			</td>
		</tr>
		<?php
	}
	?>
	</tbody>
</table>
</div>