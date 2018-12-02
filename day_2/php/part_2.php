<?php

$ids = array_filter(file($argv[1]));


foreach ($ids as $id1) {
	$id1 = trim($id1);
	
	foreach ($ids as $id2) {
		$id2 = trim($id2);
		if (levenshtein($id1, $id2) == 1) {
			// do they differ at the same index?
			foreach (str_split($id1) as $idx => $char) {
				if ($char !== $id2[$idx]) {
					$answer = str_split($id2);
					$answer[$idx] = '';
					echo implode('', $answer);
					exit(0);
				}
			}
		}
	}
}

echo "No soln found";