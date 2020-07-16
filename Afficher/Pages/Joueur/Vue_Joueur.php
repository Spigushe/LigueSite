<?php
function Affichage ($helper) {
	if (count($helper['infos']['decks']) == 0) { return ""; }
	$affichage  = Titre($helper);
	$affichage .= Presentation($helper);
	$affichage .= Saisons($helper);
	$affichage .= "";

	return $affichage;
}

function Titre ($helper) {
	ob_start(); ?>
	<div class="display-4 mb-3">Page de profil - <?= ucfirst($helper['infos']['pseudo']) ?></div>
	<?php return ob_get_clean();
}

function Presentation ($helper) {
	ob_start(); ?>
	<div class="alert alert-primary mx-5" role="alert">
		Présent⸱e depuis la saison <?= min(array_keys($helper['infos']['saisons'])) ?>
		et actuellement en
		<strong class="text-warning">
			<?= $helper['infos']['ligues'][count($helper['infos']['ligues'])-1] ?>
		</strong>,
		<?= $helper['infos']['pseudo'] ?> a joué
		<?= pluriel($helper['infos']['matchWins'] + $helper['infos']['matchLoss'], "partie") ?>
		et en a gagné <?= $helper['infos']['matchWins'] ?>
		en jouant <?= pluriel(count($helper['infos']['decks']), "deck basé") ?>
		sur <?= count($helper['infos']['generaux']) ?>
		<?= (count($helper['infos']['generaux']) > 1) ? "généraux" : "général" ?>
	</div>
	<?php return ob_get_clean();
}

function pluriel ($qty,$str) {
	$phrase = $qty." ";

	foreach (preg_split("/ /i",$str) as $word) {
		$phrase .= $word;
		$phrase .= ($qty > 1) ? "s" : "";
		$phrase .= " ";
	}

	return $phrase;
}

function Saisons ($helper) {
	$message = "<div class='d-inline-flex flex-nowrap'>";

	for ($i = __SAISON__; $i >= 1; $i--) {
		ob_start(); ?>
		<div class="p-2 mx-2">
			<p class="h4">Saison <?= $i ?></p>
			Ligue : <br>
			Général : <br>
			Winrate : <br>
		</div>
		<?php $message .= ob_get_clean();
	}
	return "<h2 class='mt-5'>Détail par saisons</h2>".$message."</div>";
}
