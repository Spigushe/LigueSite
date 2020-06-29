<?php
function tableauClassement ($helper) {
	ob_start(); ?>
	<div class="table-responsive text-nowrap">
	<table id="tableClassement" class="table table-hover" aria-describedby="tableClassement">
		<thead>
			<tr>
				<th scope="col" class="sorting align-middle" aria-controls="tableClassement">Rang</th>
				<th scope="col" class="align-middle">Joueur.se</th>
				<th scope="col" class="align-middle col-2">
					Matchs<br>
					<i><small>(<span class="text-success">Wins</span>-<span class="text-warning">Losses</span>)</small></i>
				</th>
				<th scope="col" class="align-middle">Points</th>
				<th scope="col" class="align-middle">Diff. Points</th>
			</tr>
		</thead>
		<tbody>
			<?php
			for ($i = 0; $i < count($helper['infos']['pseudo']); $i++) {
				$cle = $helper['infos']['pseudo'][$i];
			?>
			<tr>
				<td scope="row">
					<?= $helper['infos']['classement'][$cle] ?>
				</td>
				<td>
					<strong><?= $cle ?></strong>
				</td>
				<td>
					<?= afficherBarreJoueur($helper,$cle) ?>
					<?= afficheGeneral($helper[$cle]['general']) ?>
						<small>(<i><?= $helper[$cle]['hash'] ?></i>)</small>
				</td>
				<td>
					<?= $helper[$cle]['tiebreakers']['matchPoints'] ?>
				</td>
				<td>
					<?= $helper[$cle]['tiebreakers']['diffPoints'] ?>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
	</div>
	<?php return ob_get_clean();
}
