<?php

$data_file = fopen(__DIR__ . '/data.txt', 'rb');

$grid = [
    ['', '', 1, '', ''],
    ['', 2, 3, 4, ''],
    [5, 6, 7, 8, 9],
    ['', 'A', 'B', 'C', ''],
    ['', '', 'D', '', '']
];

$position = [1, 1];
echo 'The Door code is: ';
while ($line = fgets($data_file)) {
    for ($i = 0, $l = strlen($line); $i < $l; $i++) {
        $movement      = $line[$i];
        $last_position = $position;
        switch (strtoupper($movement)) {
            case 'U':
                $position[0]--;
                break;

            case 'D':
                $position[0]++;
                break;

            case 'L':
                $position[1]--;
                break;

            case 'R':
                $position[1]++;
                break;
        }
        if ($position[0] < 0) {
            $position[0] = 0;
        } elseif ($position[0] > 4) {
            $position[0] = 4;
        }
        if ($position[1] < 0) {
            $position[1] = 0;
        } elseif ($position[1] > 4) {
            $position[1] = 4;
        }

        $new_position = $grid[$position[0]][$position[1]];
        if ($new_position === '') {
            $position = $last_position;
        }
    }
    echo $grid[$position[0]][$position[1]];
}
echo "\n";
fclose($data_file);
