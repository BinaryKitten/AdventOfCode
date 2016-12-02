<?php

$data  = file_get_contents(__DIR__ . '/data.txt');
$route = explode(',', $data);
$route = array_map(function ($line) {
    return trim($line);
}, $route);

$cur_direction = 1;
$coords        = [0, 0];
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

    for($i = 1;$i <= $blocks; $i++) {
        switch ($cur_direction) {
            case 1:
                $coords[1]++;
                break;
            case 2:
                $coords[0]++;
                break;
            case 3:
                $coords[1]--;
                break;
            case 4:
                $coords[0]--;
                break;
        }
        $position = implode(',', $coords);
        if (in_array($position, $positions)) {

            break 2; // second time at this position
        }
        $positions[] = $position;
    }
}

echo 'Distance: ' . (abs($coords[0]) + abs($coords[1])) . "\n";