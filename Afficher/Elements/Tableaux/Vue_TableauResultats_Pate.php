<?php
function tableauResultats ($helper) {
	ob_start(); ?>
	<div class="table-responsive mb-5">
	<table id="tableMatches" class="table table-hover" aria-describedby="tableMatches">
		<!--<caption>Résultats des parties</caption>-->
		<thead>
			<tr>
				<th scope="col" class="sorting" aria-controls="tableMatches"></th>
			<?php
			for ($i = 0; $i < (count($helper['infos']['pseudo'])); $i++) {
				$cle = $helper['infos']['pseudo'][$i];
				?>
				<th scope="col" class="text-center"><?= $cle ?></th>
				<?php
				}
			?>
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
				<?php for ($j = 0; $j < count($helper['infos']['pseudo']); $j++) : ?>
					<td class='align-middle text-center'>
				        <?php if ($j == $i) : ?>
				            X
					    <?php else : ?>
						    <?= afficheResultat($helper,$cle,$helper['infos']['pseudo'][$j]) ?>
						<?php endif; ?>
					</td>
				<?php endfor; ?>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
	</div>
	<?php return ob_get_clean();
}
