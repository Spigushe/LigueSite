<?php
function tableauParties ($helper) {
	ob_start(); ?>
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
		for ($i = 0; $i < count($helper['infos']['pseudo']); $i++) {
			$cle = $helper['infos']['pseudo'][$i];
			$parties = $helper[$cle]['parties'];
			?>
			<tr>
				<th scope="row" class="align-middle">
					<!-- Ligue -->
					<img src="Afficher/Icones/Placement-<?= min(3,$helper[$cle]['victoires']) ?>.png" width="32px">
					<span class='sr-only sr-only-focusable'><?= getLigue(min(3,$helper[$cle]['victoires'])) ?></span>
					<!-- Pseudo -->
					<?= $cle ?>
				</th>
				<td class="align-middle sorting_1">
					<!-- Général -->
					<?= afficheGeneralMetagame($helper[$cle]['general']) ?>
				</td>
				<td class="align-middle">
					<!-- Parties gagnées -->
					<?php foreach ($helper['infos']['pseudo'] as $key => $pseudo) :
						// On ne s'affronte pas
						if ($pseudo == $cle) continue;
						if ($parties[$pseudo]['p_result'] > $parties[$pseudo]['o_result']) : ?>
							<span>
								[<?= $parties[$pseudo]['string'] ?>]
								<?= $parties[$pseudo]['o_pseudo'] ?>
								(<?= afficheGeneralInline($helper[$pseudo]['general'])?>)
							</span><br/>
						<?php endif;
					endforeach; ?>
				</td>
				<td class="align-middle">
					<!-- Parties perdues -->
					<?php foreach ($helper['infos']['pseudo'] as $key => $pseudo) {
						// On ne s'affronte pas
						if ($pseudo == $cle) continue;
						if ($parties[$pseudo]['o_result'] > $parties[$pseudo]['p_result']) : ?>
							<span>
								[<?= $parties[$pseudo]['string'] ?>]
								<?= $parties[$pseudo]['o_pseudo'] ?>
								(<?= afficheGeneralInline($helper[$pseudo]['general'])?>)
							</span><br/>
						<?php endif;
					}?>
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
