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
	<?php
	$infos = transposeGeneraux($infos);
	$cles = array_keys($infos);
	for ($i = 0; $i < count($infos); $i++) {
		?>
		<tr>
			<th scope="row" class="align-middle"><?= afficheGeneral($cles[$i],'principal') ?></th>
			<td class="align-middle"><?php
			for ($j = 0; $j < count($infos[$cles[$i]]); $j++) {
				$victoires = (!isset($resultats[$infos[$cles[$i]][$j]]['victoires'])) ? 0 : count($resultats[$infos[$cles[$i]][$j]]['victoires']);
				$defaites = (!isset($resultats[$infos[$cles[$i]][$j]]['defaites'])) ? 0 : count($resultats[$infos[$cles[$i]][$j]]['defaites']);
					
				echo "[$victoires-$defaites] " . $infos[$cles[$i]][$j] . "<br>";
			}
			?></td>
			<td class="align-middle"><?php
			$victoires = array();
			for ($j = 0; $j < count($infos[$cles[$i]]); $j++) {
				if (!isset($resultats[$infos[$cles[$i]][$j]]['victoires'])) $victoires[] = 0;
				else $victoires[] = min(3,count($resultats[$infos[$cles[$i]][$j]]['victoires']));
			}
			for ($j = 0; $j <= 3; $j++) {
				for ($k = 0; $k < count($victoires) ; $k++) {
					if ($victoires[$k] == (3 - $j)) {
						echo "<img src=\"Afficher/Icones/Placement-".$victoires[$k].".png\" width='32px'>";
						switch ($victoires[$k]) {
							case '3':
								echo "<span class='sr-only sr-only-focusable'>Gold / Or</span>";
								break;
							case '2':
								echo "<span class='sr-only sr-only-focusable'>Silver / Argent</span>";
								break;
							case '1':
								echo "<span class='sr-only sr-only-focusable'>Bronze / Bronze</span>";
								break;
							case '0':
								echo "<span class='sr-only sr-only-focusable'>Wood / Bois</span>";
								break;
						}
					}
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

<?php
function transposeGeneraux ($infos) {
	$tampon = array();
	
	// On récupère les généaux
	for ($i = 0, $j = 0; $i < count($infos); $i++) {
		if(!isset($tampon[$infos[$i]['general']]) || ($tampon[$infos[$i]['general']] == "")) {
		 	$tampon[$infos[$i]['general']] = $j;
		 	$j++;
		}
	}
	
	// On fait un tri pour l'affichage
	$tampon = triAlpha($tampon);
	
	// On indique quel joueur joue quel deck
	for ($i = 0; $i < count($infos); $i++) {
		if (gettype($tampon[$infos[$i]['general']]) === "integer") {
			$tampon[$infos[$i]['general']] = array();
		}
		$tampon[$infos[$i]['general']][] = $infos[$i]['pseudo'];
	}
	
	return $tampon;
}

function triAlpha ($tableau) {
	// Tableau array('%general'=>array('joueurs');
	$tableau = array_flip($tableau);
	$tampon = array();
	for ($j = 0; $j < (count($tableau) - 1); $j++) {
		for ($i = 1; $i < count($tableau); $i++) {
			if (strcasecmp($tableau[$i-1],$tableau[$i]) > 0) {
				$tampon = $tableau[$i-1];
				$tableau[$i-1] = $tableau[$i];
				$tableau[$i] = $tampon;
			}
		}
	}
	return array_flip($tableau);
}
?>