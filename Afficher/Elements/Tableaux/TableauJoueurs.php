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
		for ($i = 0; $i < count($infos); $i++) {
		?>
		<tr>
			<td scope="row" class="align-middle">
				<strong><?= $infos[$i]['pseudo'] ?></strong>
				<!--<br><?= afficheGeneral($infos[$i]['general'], 'resultat') ?>-->
			</td>
			<td>
				<?= afficherBarreJoueur($infos,$i) ?>
				<?= afficheGeneral($infos[$i]['general'],'inline') ?>
					<small>(<i><?= afficheHash($infos[$i]['id_discord']) ?></i>)</small>
			</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
</div>

<?php
function afficherBarreJoueur ($infos,$rang) {
	ob_start();
	include('Afficher/Elements/Barres/BarreJoueur.php');
	return ob_get_clean();
}
?>
