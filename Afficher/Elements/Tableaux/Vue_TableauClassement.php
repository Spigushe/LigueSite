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
				<?php if (isset($_GET['ligue']) && ($_GET['ligue'] == 'Elo-Aout')) : ?>
				<th scope="col" class="align-middle">
					<span href="#" data-toggle="tooltip" title="Info will change as new leagues are run">
						ELO
					</span>
				</th>
				<?php endif; ?>
				<th scope="col" class="align-middle">
					Score
				</th>
				<th scope="col" class="align-middle">
					<span href="#" data-toggle="tooltip" title="Game won minus game lost">
						Diff. Points
					</span>
				</th>
				<th scope="col" class="align-middle">
					<span href="#" data-toggle="tooltip" title="Game won against tied opponents">
						Tied Opp.
					</span>
				</th>
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
				<?php if (isset($_GET['ligue']) && ($_GET['ligue'] == 'Elo-Aout')) : ?>
				<td class="align-middle">
					<?= $helper[$cle]['elo'] ?>
				</td>
				<?php endif; ?>
				<td class="align-middle">
					<?= $helper[$cle]['tiebreakers']['matchPoints'] ?>
				</td>
				<td class="align-middle">
					<?= $helper[$cle]['tiebreakers']['diffPoints'] ?>
				</td>
				<td class="align-middle">
					<?= $helper[$cle]['tiebreakers']['tiedParticipants'] ?>
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
