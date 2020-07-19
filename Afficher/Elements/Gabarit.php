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
	<h1 class="display-2 m-3 p-1">
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

	<footer class="container sticky-bottom text-center">
	2020 - <b>Commander League</b>, un projet de Guillaume "Cleomene" Cailliez avec l'assistance de Geoffrey "Linkanor" et de Martin "Spigushe"
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
<script src="popper.min.js"></script>
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
