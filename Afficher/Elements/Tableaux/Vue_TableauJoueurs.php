<?php
function tableauJoueurs ($helper) {
	ob_start(); ?>
	<div class="table-responsive text-nowrap">
	<table id="tableJoueurs" class="table table-hover" aria-describedby="tableJoueurs">
		<thead>
			<tr>
				<th scope="col" class="sorting" aria-controls="tableJoueurs">Joueur.se</th>
				<th scope="col" class="col-9">Informations</th>
			</tr>
		</thead>
		<tbody>
			<?php
			for ($i = 0; $i < count($helper['infos']['pseudo']); $i++) {
				$cle = $helper['infos']['pseudo'][$i];
			?>
			<tr>
				<td scope="row" class="align-middle">
					<strong><?= $cle ?></strong>
				</td>
				<td>
					<?= afficherBarreJoueur($helper,$cle) ?>
					<?= afficheGeneral($helper[$cle]['general']) ?>
						<small>(<i><?= $helper[$cle]['hash'] ?></i>)</small>
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
