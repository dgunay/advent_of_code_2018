<?php

require_once(__DIR__ . '/include/Claim.php');
require_once(__DIR__ . '/include/Square.php');

ini_set('memory_limit', '256M'); // I'm a bad programmer

function parse_claim(string $line) : Claim {
	if (preg_match('/#(\d+?) @ (\d+?),(\d+?): (\d+?)x(\d+)/', $line, $matches)) {
		return new Claim($matches);
	}

	throw new \RuntimeException("Couldn't parse claim.");
}

// Get our claims from the input.
$claims = array_map('parse_claim', array_filter(file($argv[1])));

// How big does the fabric need to be? It's a square so we only need calculate
// one side.
// biggest from left + width
$biggest = 0;
foreach ($claims as $claim) {
	$length = $claim->in_from_left_edge() + $claim->width();
	if ($length > $biggest) {
		$biggest = $length;
	}
}

// Construct a fabric of squares. We can't use array_fill because it fills by
// reference.
$fabric = [];
for ($i = 0 ; $i < $biggest; $i++) {
	$fabric[$i] = [];
	for ($j = 0 ; $j < $biggest; $j++) {
		$fabric[$i][$j] = new Square();
	}
}

foreach ($claims as $claim) {
	foreach ($claim->coords_occupied() as $pair) {
		$fabric[$pair[0]][$pair[1]]->occupy($claim);
	}
}

// Which claim is not overlapping with any other?
foreach ($claims as $a) {
	// Check the fabric at all coordinates occupied by this claim, for any other
	// claims.
	$intersects_with_any_other_claims = false;
	foreach ($a->coords_occupied() as $pair) {
		$occupants = $fabric[$pair[0]][$pair[1]]->get_occupants();
		if (count($occupants) > 1) {
			$intersects_with_any_other_claims = true;
			break;
		}
	}

	// No other claims? Winner!
	if (!$intersects_with_any_other_claims) {
		echo $a->id();
		break;
	}
}


// Prints the fabric to stdout
function visualize(array $fabric) {
	foreach ($fabric as $row) {
		foreach ($row as $square) {
			if ($square->occupied()) {
				echo "#";
			}
			else {
				echo "-";
			}
		}
		echo "\n";
	}
}