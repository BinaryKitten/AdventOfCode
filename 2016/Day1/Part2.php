<?php
/**
 * --- Part Two ---
 *
 * Then, you notice the instructions continue on the back of the Recruiting Document.
 * Easter Bunny HQ is actually at the first location you visit twice.
 *
 * For example, if your instructions are R8, R4, R4, R8, the first location you visit twice is
 * 4 blocks away, due East.
 *
 * How many blocks away is the first location you visit twice?
 */

$data  = file_get_contents(__DIR__ . '/data.txt');
$route = explode(',', $data);
$route = array_map(function ($line) {
    return trim($line);
}, $route);

$cur_direction = 1;
$coordinates   = [0, 0];
$positions     = [];

foreach ($route as $idx => $direction) {
    $turn   = $direction[0];
    $blocks = (int)substr($direction, 1);

    $cur_direction += ($turn === 'L') ? -1 : +1;
    if ($cur_direction > 4) {
        $cur_direction = 1;
    } elseif ($cur_direction < 1) {
        $cur_direction = 4;
    }

    for ($i = 1; $i <= $blocks; $i++) {
        switch ($cur_direction) {
            case 1:
                $coordinates[1]++;
                break;
            case 2:
                $coordinates[0]++;
                break;
            case 3:
                $coordinates[1]--;
                break;
            case 4:
                $coordinates[0]--;
                break;
        }
        $position = implode(',', $coordinates);
        if (in_array($position, $positions)) {
            break 2; // second time at this position
        }
        $positions[] = $position;
    }
}

echo 'Distance: ' . (abs($coordinates[0]) + abs($coordinates[1])) . "\n";