<?php
function tableauClassement ($helper) {
	ob_start(); ?>
	<div class="table-responsive text-nowrap">
	<table id="tableClassement" class="table table-hover" aria-describedby="tableClassement">
		<thead>
			<tr>
				<th scope="col" class="sorting align_middle" aria-controls="tableClassement">Rang</th>
				<th scope="col" class="align_middle">Joueur.se</th>
				<th scope="col">
					Matchs
					<i><small>(<span class="text-success">Wins</span>-<span class="text-warning">Losses</span>)</small></i>
				</th>
				<th scope="col">Points</th>
				<th scope="col">Game Win %</th>
				<th scope="col">Opp Game Win %</th>
				<th scope="col">Match Win %</th>
				<th scope="col">Opp Match Win %</th>
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
				</td>
				<td>
					<?= $helper[$cle]['tiebreakers']['matchPoints'] ?>
				</td>
				<td>
					<?= $helper[$cle]['tiebreakers']['gameWinPercentage']*100 ?> %
				</td>
				<td>
					<?= $helper[$cle]['tiebreakers']['o_gameWinPercentage']*100 ?> %
				</td>
				<td>
					<?= $helper[$cle]['tiebreakers']['matchWinPercentage']*100 ?> %
				</td>
				<td>
					<?= $helper[$cle]['tiebreakers']['o_matchWinPercentage']*100 ?> %
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
