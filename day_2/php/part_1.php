<?php

$ids = array_filter(file($argv[1]));

$doubles = 0;
$triples = 0;
foreach ($ids as $id) {
	$id = trim($id);
	$char_counts = [];

	foreach (str_split($id) as $char) {
		if (array_key_exists($char, $char_counts)) {
			$char_counts[$char]++;
		}
		else {
			$char_counts[$char] = 1;
		}
	}

	$seen_double = false;
	$seen_triple = false;
	foreach ($char_counts as $char => $count) {
		if ($count == 2 && !$seen_double) {
			$doubles++;
			$seen_double = true;
		}
		elseif ($count == 3 && !$seen_triple) {
			$triples++;
			$seen_triple = true;
		}

		if ($seen_double && $seen_triple) break;
	}
}

echo $doubles . " " . $triples;