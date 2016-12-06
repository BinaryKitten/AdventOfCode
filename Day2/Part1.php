<?php

$data_file = fopen(__DIR__ . '/data.txt', 'rb');

$grid = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
];

$position = [1, 1];
echo 'The Door code is: ';
while ($line = fgets($data_file)) {
    for ($i = 0, $l = strlen($line); $i < $l; $i++) {
        $movement = $line[$i];
        switch (strtoupper($movement)) {
            case 'U':
                if ($position[0] > 0) {
                    $position[0]--;
                }
                break;

            case 'D':
                if ($position[0] < 2) {
                    $position[0]++;
                }
                break;

            case 'L':
                if ($position[1] > 0) {
                    $position[1]--;
                }
                break;

            case 'R':
                if ($position[1] < 2) {
                    $position[1]++;
                }
                break;
        }
    }
    echo $grid[$position[0]][$position[1]];
}
echo "\n";
fclose($data_file);
