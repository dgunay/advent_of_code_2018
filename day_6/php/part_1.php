<?php

if (!array_key_exists(1, $argv)) {
  exit('input file pls');
}

$pairs  = array_map(
  function($str) { return array_map('trim', explode(',', $str)); },
  file($argv[1])
);

