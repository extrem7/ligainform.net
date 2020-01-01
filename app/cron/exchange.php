<?php

define('WP_USE_THEMES', false);

$start = microtime(true);

require_once('../../../../../wp-load.php');

$rates = league()->exchange();
$update = '|';
foreach ($rates as $ccy => $rate) $update .= "$ccy -> $rate|";

$finish = microtime(true);
$time = round(($finish - $start), 1);
$memory = round(memory_get_peak_usage() / 1048576, 1);

$text = date("d.m.y g:i") . " duration: $time sec, update: $update\n";

$filename = 'exchange.txt';
$file = file_get_contents($filename);
file_put_contents($filename, $text . $file);
