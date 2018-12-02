<?php

$lines = array_filter(file($argv[1]));

$freq = 0;
$encountered_freqs = [];
while (true) {
  foreach ($lines as $line) {
    $op = $line[0];
  
    $num = trim(substr($line, 1));
    
    $op === '+' ? $freq += $num : $freq -= $num;
    
    if (array_key_exists($freq, $encountered_freqs)) {
      echo $freq;
      exit(0);
    }
    else {
      $encountered_freqs[$freq] = true;
    }
  }
}