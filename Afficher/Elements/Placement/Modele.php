<?php
/************
TableauLigues
************/
function getLigue($int) {
	$ligues  = array();
	$ligues[] = "Bois / Wood";
	$ligues[] = "Bronze / Bronze";
	$ligues[] = "Argent / Silver";
	$ligues[] = "Or / Gold";
	$ligues[] = "Platine / Platinium";
	return $ligues[$int];
}
/************
TableauMetagame
************/
function tableauMetagame ($helper) {
	// Transposition du helper
	sort($helper['infos']['pseudo']);
	$lignes = array();
	for ($i = 0; $i < count($helper['infos']['pseudo']); $i++) {
		$cle = $helper['infos']['pseudo'][$i];
		if (!in_array($helper[$cle]['general'], $lignes)) {
			$lignes[$helper[$cle]['general']]['general'] = afficheGeneralMetagame($helper[$cle]['general']);
			$lignes[$helper[$cle]['general']]['joueurs'][] = $cle;
			$lignes[$helper[$cle]['general']][$cle]['parties'] = $helper[$cle]['victoires'] . " - " . $helper[$cle]['defaites'];
			$lignes[$helper[$cle]['general']][$cle]['ligue'] = min(3,$helper[$cle]['victoires']);
		}
	}
	// L'élément avec affichage décalé grace à ob_start et ob_get_clean
	ob_start();
	require_once('Afficher/Elements/Placement/TableauMetagame.php');
	return ob_get_clean();
}

/************
TableauMetagame
************/
function tableauParties ($helper) {
	sort($helper['infos']['pseudo']);
	ob_start();
	require_once('Afficher/Elements/Placement/TableauParties.php');
	return ob_get_clean();
}

/*

*/
function afficheGeneralMetagame ($texte) {
	// De quoi est composée la command zone ?
	$contraintes = "";
	if (preg_match('/\//i',$texte)) $contraintes .= "P";
	if (preg_match('/\(/i',$texte)) $contraintes .= "C";
	// S'il n'y a qu'une carte
	if ($contraintes == "") return $texte;

	// Traitement des partenaires
	if (preg_match('/p/i',$contraintes)) {
		$liste_partners = (preg_match('/c/i',$contraintes)) ? preg_split('/\(/',$texte)[0] : $texte;
		$partenaires = array(preg_split('/\/\//i',$liste_partners)[0],preg_split('/\/\//i',$liste_partners)[1]);
		$retour = imagePartenaires("principal") . "<div>" . $partenaires[0] . "<br />" . $partenaires[1] . "</div>";
	}

	// Traitement des compagnons
	if (preg_match('/c/i',$contraintes)) {
		$compagnon = substr(preg_split('/\(/',$texte)[1],0,strlen(preg_split('/\(/',$texte)[1])-1);
		// S'il y a en plus des partenaires
		if (preg_match('/p/i',$contraintes)) {
			$retour .= "<div>" . imageCompagnon() . $compagnon . "</div>";
		}
		// S'il n'y a pas de partenaires
		else {
			$retour = preg_split('/\(/i',$texte)[0] . //
						"<div>" . imageCompagnon() . $compagnon . "</div>";
		}
	}

	return $retour;
}

function afficheGeneralInline ($texte) {
	// De quoi est composée la command zone ?
	$contraintes = "";
	if (preg_match('/\//i',$texte)) $contraintes .= "P";
	if (preg_match('/\(/i',$texte)) $contraintes .= "C";
	// S'il n'y a qu'une carte
	if ($contraintes == "") return $texte;

	// Traitement des partenaires
	if (preg_match('/p/i',$contraintes)) {
		// Les deux partenaires
		$partenaires = array(
			preg_split('/[\s,]+/',preg_split('/\/\//i',$texte)[0])[0],
			preg_split('/[\s,]+/',preg_split('/\/\//i',$texte)[1])[1]
		);
		// Le texte à afficher
		$liste_partners = (preg_match('/c/i',$contraintes)) ? preg_split('/\(/',$texte)[0] : $texte;
		//Le retour
		$retour = imagePartenaires() . //
			"<a class='text-decoration-none text-reset' title='$liste_partners'>" . //
			$partenaires[0] . " / " . $partenaires[1] . "</a>";
	}

	// Traitement des compagnons
	if (preg_match('/c/i',$contraintes)) {
		$compagnon = substr(preg_split('/\(/',$texte)[1],0,strlen(preg_split('/\(/',$texte)[1])-1);
		// S'il y a en plus des partenaires
		if (preg_match('/p/i',$contraintes)) {
			$retour .= " + " . imageCompagnon($compagnon);
		}
		// S'il n'y a pas de partenaires
		else {
			$retour = preg_split('/\(/i',$texte)[0] . //
						" + " . imageCompagnon($compagnon);
		}
	}

	return $retour;
}

/**********
afficheGroupe
**********/
function afficheGroupe ($groupe,$infos) {
	// Définition des variables
	$max    = $infos['maxMatches'];
	$played = $infos['matches'];
	$status = $infos['avancement'];
	// L'élément avec affichage décalé grace à ob_start et ob_get_clean
	ob_start(); ?>
	<div>
		<p class='h3 text-decoration-none'>
			<a href="/Saison-<?= $_GET['saison'] ?>/Ligue-Placement-<?= $groupe ?>" class="text-reset">
				Groupe <?= $groupe ?>
			</a>
		</p>
		<div class="progress my-2" style="height: 20px;">
			<div class="progress-bar bg-info" role="progressbar" aria-valuenow="25"
				aria-valuemin="0" aria-valuemax="<?= $max ?>" style="width:<?= $status ?>%" >
			<?= $status ?> %</div>
		</div>

		<p class="text-center">
			<i><?= $played ?> matches joués sur <?= $max ?></i>
		</p>
	</div>
	<?php $retour = ob_get_clean();
	return $retour;
}
