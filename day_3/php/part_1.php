<?php

require_once(__DIR__ . '/include/Claim.php');
require_once(__DIR__ . '/include/Square.php');

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
	// Compute which squares are occupied by this claim
	$left = $claim->in_from_left_edge();
	$top  = $claim->in_from_top_edge();

	$horizontal = range($left, $left + $claim->width()  - 1);
	$vertical   = range($top,  $top  + $claim->height() - 1);
	foreach ($horizontal as $y) {
		foreach ($vertical as $x) {
			// Occupy those squares
			$fabric[$x][$y]->occupy($claim);
		}
	}
}

// Count the number of Squares occupied by 2 or more claims.
$count = 0;
foreach ($fabric as $row) {
	foreach ($row as $square) {
		if (count($square->get_occupants()) > 1) { $count++; }
	}
}

echo $count;


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