<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<base href="/">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="/Afficher/Addons/darkly.theme.bootstrap.css">

	<!-- Font Style Definition -->
	<link rel="stylesheet" href="/Afficher/CSS/Polices/pr-columbandemo.css">
	<link rel="stylesheet" href="/Afficher/CSS/overriding.css">

	<title>Commander League</title>
</head>
<body>
<div class="container">
	<h1 class="display-2 m-3 p-1 custom-font">
		<img src="Afficher/CSS/Images/Logo.png" height="200" class='float-right mx-2' alt="">
		Commander League
	</h1>

	<?php require_once 'Afficher/Elements/Menu.php'; ?>

	<?php if (__LIGUE__ != "") : ?>
		<div class="display-4 mb-5">Saison <?= __SAISON__ ?> - Ligue <?= ucfirst(__LIGUE__) ?></div>
	<?php endif; ?>

	<?php if (__LIGUE__ == "") : ?>
		<div class="display-4 mb-5">Avancement de la saison en cours</div>
	<?php endif; ?>

	<div id="contenu">
	<?= $contenu ?>
	</div>

	<div class="pb-3">
	</div>
</div>

<div class="container">
	<footer class="container sticky-bottom bg-dark d-inline-flex py-3 px-1">
		<img src="Afficher/CSS/Images/Logo.png" class="col-2 d-none d-lg-block" />

		<div class="">
			<strong class="text-info custom-font">Commander League</strong><br>
			Projet de ligue Duel Commander en ligne en alliant
			<a href="https://discord.gg/vbTyu9A"
				target="_blank" class="text-decoration-none text-white">
				Discord
			</a>
			et
			<a href="https://cockatrice.github.io/"
				target="_blank" class="text-decoration-none text-white">
				Cockatrice
			</a>
			créé par Guillaume Cailliez
			avec le soutien technique de Martin Cuchet

			<br><br>
			Vous pouvez nous retrouver sur
			<a href="https://www.facebook.com/liguecommander"
				target="_blank" class="text-decoration-none text-white">
				Facebook
			</a>
			et sur
			<a href="https://discord.gg/vbTyu9A"
				target="_blank" class="text-decoration-none text-white">
				Discord
			</a>
		</div>

		<div class="col-3 d-none d-md-block">
			<strong class="text-info custom-font">Ressources</strong><br>
			<a href="https://docs.google.com/document/d/18_-bRp1yxlMS9Vkz5fQ9ypG8J49oPEZkfBEp1QnhhV0"
				target="_blank" class="text-decoration-none text-white">
				Règlement de la ligue
			</a><br>
			<a href="https://www.facebook.com/notes/mtg-duel-commander/duel-commander-current-lists/1698432663740967"
				target="_blank" class="text-decoration-none text-white">
				Liste des cartes bannies
			</a><br><br>

			Cockatrice et Discord sont des outils disponibles sur
			toute plateforme<br><br>

			<div class="my-2 d-inline-flex flex-wrap">
				<a href="https://www.facebook.com/liguecommander" target="_blank" class="mx-2">
					<img src="/Afficher/CSS/Images/Facebook.png" height="32" alt="" />
				</a>
				<a href="https://discord.gg/vbTyu9A" target="_blank" class="mx-2">
					<img src="/Afficher/CSS/Images/Discord.png" height="32" alt="" />
				</a>
				<a href="https://cockatrice.github.io/" target="_blank" class="mx-2">
					<img src="/Afficher/CSS/Images/Cockatrice.png" height="32" alt="Cockatrice" />
				</a>
				<a href="https://github.com/Spigushe/LigueSite" target="_blank" class="mx-2">
					<img src="/Afficher/CSS/Images/GitHub.png"  height="32" alt="GitHub" />
				</a>
			</div>
		</div>

		<div class="col-3 d-none d-md-block">
			<strong class="text-info custom-font">Nous aider</strong><br>
			L'ensemble de la ligue est disponible en open-source sur
			<a href="https://github.com/Spigushe/LigueSite"
				target="_blank" class="text-decoration-none text-white">
				GitHub
			</a>.
			Les contributions sont les bienvenues. Les Pull Requests
			seront fusionnées si elles respectent le style général.
			Les problèmes seront réglés au plus vite
		</div>
	</footer>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!-- Optional Plugins -->

<!-- API TappedOut -->
<!-- https://tappedout.github.io/ --><script src="http://tappedout.net/tappedout.js"></script>

<!-- ToolTip -->
<script>
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})
</script>

<!-- DataTables dependancies -->
<link rel="stylesheet" href="Afficher/Addons/datatables.bootstrap4.css">
<script src="Afficher/Addons/jquery.datatables.js"></script>
<script src="Afficher/Addons/datatables.bootstrap4.js"></script>

<script>
$(document).ready(function() {
    $('#tablePlacements').DataTable({
		"order": [[ 0, "asc"]],
		"aaSorting": [],
		columnDefs: [
			{'orderable'	: false, 'targets': [2,3]},
			{'searchable'	: false, 'targets': [2,3]},
		]
	});

    $('#tableMetagame').DataTable({
		"order": [[ 0, "asc"]],
		"aaSorting": [],
		columnDefs: [
			{'orderable'	: false, 'targets': [1,2]},
			//{'searchable'	: false, 'targets': [2]},
		]
	});

	$('#tableJoueurs').DataTable({
		"order": [[ 0, "asc"]],
		"aaSorting": [],
		columnDefs: [
			{'orderable'	: false, 'targets': [1]},
			{'searchable'	: false, 'targets': 1},
		]
	});

	$("#tableClassement").DataTable();
});
</script>
</body>
</html>
