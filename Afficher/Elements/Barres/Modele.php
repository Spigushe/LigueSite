<?php
function getMatchesPlayed ($helper) {
	$count = 0;

	foreach (array_keys($helper) as $deck1) {
		foreach (array_keys($helper[$deck1]) as $deck2) {
			$count += count($helper[$deck1][$deck2]);
		}
	}

	return $count/2;
}

function getMaxMatches ($helper) {
	// Somme de 1 à n = n * (n+1) / 2
	return count($helper)*(count($helper)-1)/2;
}
