<?php

$data_file = fopen(__DIR__ . '/data.txt', 'rb');

$invalid = 0;
$valid   = 0;
while ($line = fgets($data_file)) {
    $items   = array_values(array_filter(explode(' ', $line)));

    $result1 = ($items[0] + $items[1]) > $items[2];
    $result2 = ($items[1] + $items[2]) > $items[0];
    $result3 = ($items[0] + $items[2]) > $items[1];

    if ($result1 && $result2 && $result3) {
        $valid++;
    } else {
        $invalid++;
    }
}
echo 'There are ' . $valid . ' Triangles' . "\n";

fclose($data_file);
