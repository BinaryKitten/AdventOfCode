<?php
/**
 * --- Part Two ---
 *
 * You finally arrive at the bathroom (it's a several minute walk from the lobby so visitors can behold the
 * many fancy conference rooms and water coolers on this floor) and go to punch in the code.
 * Much to your bladder's dismay, the keypad is not at all like you imagined it.
 *
 * Instead, you are confronted with the result of hundreds of man-hours of bathroom-keypad-design meetings:
 *
 *     1
 *   2 3 4
 * 5 6 7 8 9
 *   A B C
 *     D
 *
 * You still start at "5" and stop when you're at an edge, but given the same instructions as above,
 * the outcome is very different:
 *
 * You start at "5" and don't move at all (up and left are both edges), ending at 5.
 * Continuing from "5", you move right twice and down three times (through "6", "7", "B", "D", "D"), ending at D.
 * Then, from "D", you move five more times (through "D", "B", "C", "C", "B"), ending at B.
 * Finally, after five more moves, you end at 3.
 * So, given the actual keypad layout, the code would be 5DB3.
 *
 * Using the same instructions in your puzzle input, what is the correct bathroom code?
 */

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
