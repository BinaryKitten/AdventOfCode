<?php
/**
 * --- Day 3: Spiral Memory ---
 *
 * You come across an experimental new kind of memory stored on an infinite two-dimensional grid.
 *
 * Each square on the grid is allocated in a spiral pattern starting at a location marked 1 and then counting up
 * while spiraling outward. For example, the first few squares are allocated like this:
 *
 * 17    16    15    14    13
 * 18    05    04    03    12
 * 19    06    01    02    11
 * 20    07    08    09    10
 * 21    22    23---> ...
 * While this is very space-efficient (no squares are skipped), requested data must be carried back to square 1
 * (the location of the only access port for this memory system) by programs that can only move up, down, left,
 * or right. They always take the shortest path: the Manhattan Distance between the location of the data and square 1.
 *
 * For example:
 *
 * Data from square 1 is carried 0 steps, since it's at the access port.
 * Data from square 12 is carried 3 steps, such as: down, left, left.
 * Data from square 23 is carried only 2 steps: up twice.
 * Data from square 1024 must be carried 31 steps.
 *
 * How many steps are required to carry the data from the square identified in your puzzle input all the way
 * to the access port?
 * */

$input = 289326;
$demo  = 23;

function get_spiral($n, $debug = false)
{
    $cur_direction            = 'R';
    $coordinates              = [0, 0];
    $top_left_coordinates     = [0, 0];
    $bottom_right_coordinates = [0, 0];

    echo $debug ? '1: [' . implode(',', $coordinates) . ']' . "\n" : '';
    for ($i = 2; $i <= $n; $i++) {

        switch ($cur_direction) {
            case 'U':
                $coordinates[1]--;
                break;
            case 'D':
                $coordinates[1]++;
                break;
            case 'L':
                $coordinates[0]--;
                break;
            case 'R':
                $coordinates[0]++;
                break;
        }

        echo $debug ? $i . ': [' . implode(',', $coordinates) . ']' . "\n" : '';

        if ($coordinates[0] > $bottom_right_coordinates[0]) {
            $bottom_right_coordinates[0]++;
            $cur_direction = 'U';
        } elseif ($coordinates[1] < $top_left_coordinates[1]) {
            $top_left_coordinates[1]--;
            $cur_direction = 'L';
        } elseif ($coordinates[1] > $bottom_right_coordinates[1]) {
            $bottom_right_coordinates[1]++;
            $cur_direction = 'R';
        } elseif ($coordinates[0] < $top_left_coordinates[0]) {
            $top_left_coordinates[0]--;
            $cur_direction = 'D';
        }

    }

    return $coordinates;
}

$test_values = [1, 12, 23, 1024, $input];
$results     = array_combine(
    $test_values,
    array_map(
        'get_spiral',
        $test_values
    )
);


foreach ($results as $value => $result) {
    echo 'Steps from ' . $value . ' to 1: ' . (abs($result[0]) + abs($result[1])) . "\n";
}

// Your puzzle answer was 419.
