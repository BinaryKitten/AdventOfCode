<?php
/**
 * --- Day 1: No Time for a Taxicab ---
 *
 * Santa's sleigh uses a very high-precision clock to guide its movements, and the clock's oscillator is
 * regulated by stars. Unfortunately, the stars have been stolen... by the Easter Bunny.
 * To save Christmas, Santa needs you to retrieve all fifty stars by December 25th.
 *
 * Collect stars by solving puzzles. Two puzzles will be made available on each day in the advent calendar;
 * the second puzzle is unlocked when you complete the first. Each puzzle grants one star. Good luck!
 *
 * You're airdropped near Easter Bunny Headquarters in a city somewhere. "Near", unfortunately, is as close as
 * you can get - the instructions on the Easter Bunny Recruiting Document the Elves intercepted start here,
 * and nobody had time to work them out further.
 *
 * The Document indicates that you should start at the given coordinates (where you just landed) and face North.
 * Then, follow the provided sequence: either turn left (L) or right (R) 90 degrees, then walk forward the given
 * number of blocks, ending at a new intersection.
 *
 * There's no time to follow such ridiculous instructions on foot, though, so you take a moment and work out
 * the destination. Given that you can only walk on the street grid of the city, how far is the shortest path
 * to the destination?
 *
 * For example:
 *
 * Following R2, L3 leaves you 2 blocks East and 3 blocks North, or 5 blocks away.
 * R2, R2, R2 leaves you 2 blocks due South of your starting position, which is 2 blocks away.
 * R5, L5, R5, R3 leaves you 12 blocks away.
 * How many blocks away is Easter Bunny HQ?
 */

$data  = file_get_contents(__DIR__ . '/data.txt');
$route = explode(',', $data);
$route = array_map(function ($line) {
    return trim($line);
}, $route);

$cur_direction = 1;
$coordinates   = [0, 0];

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
            $coordinates[1] += $blocks;
            break;
        case 2:
            $coordinates[0] += $blocks;
            break;
        case 3:
            $coordinates[1] -= $blocks;
            break;
        case 4:
            $coordinates[0] -= $blocks;
            break;
    }
}

echo 'Distance: ' . (abs($coordinates[0]) + abs($coordinates[1])) . "\n";