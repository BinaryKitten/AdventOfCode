<?php

$data  = file_get_contents(__DIR__ . '/data.txt');
$route = explode(',', $data);
$route = array_map(function ($line) {
    return trim($line);
}, $route);

$cur_direction = 1;
$coords        = [0, 0];

foreach ($route as $direction) {
    $turn   = $direction[0];
    $blocks = (int)substr($direction, 1);

    $cur_direction += ($turn === 'L') ? -1 : +1;
    if ($cur_direction > 4) {
        $cur_direction = 1;
    } elseif ($cur_direction < 1) {
        $cur_direction = 4;
    }

    switch ($cur_direction) {
        case 1:
            $coords[1] += $blocks;
            break;
        case 2:
            $coords[0] += $blocks;
            break;
        case 3:
            $coords[1] -= $blocks;
            break;
        case 4:
            $coords[0] -= $blocks;
            break;
    }
}

echo 'Distance: ' . (abs($coords[0]) + abs($coords[1])) . "\n";