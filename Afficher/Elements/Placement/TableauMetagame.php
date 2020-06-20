<div class="table-responsive text-nowrap mb-5">
<table id="tableMetagame" class="table table-hover" aria-describedby="tableMetagame">
	<!--<caption>Résultats des parties</caption>-->
	<thead>
		<tr>
			<th scope="col" class="sorting" aria-controls="tablePlacements">Général</th>
			<th scope="col">Joueurs.ses</th>
			<th scope="col">Placement</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($lignes as $general => $ligne): ?>
		<tr>
			<td class="align-middle"><?= $ligne['general'] ?></td>
			<td class="align-middle">
				<?php for ($i = 0; $i < count ($ligne['joueurs']); $i++) {
					echo "[".$ligne[$ligne['joueurs'][$i]]['parties']."] ".$ligne['joueurs'][$i]."<br>";
				} ?>
			</td>
			<td class="align-middle">
				<?php for ($i = 0; $i < count ($ligne['joueurs']); $i++) : ?>
					<img src="Afficher/Icones/Placement-<?= $ligne[$ligne['joueurs'][$i]]['ligue'] ?>.png" width="32px">
					<span class='sr-only sr-only-focusable'><?= getLigue($ligne[$ligne['joueurs'][$i]]['ligue']) ?></span>
				<?php endfor; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
</div>
