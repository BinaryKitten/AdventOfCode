<?php
/**
 * --- Part Two ---
 *
 * As a stress test on the system, the programs here clear the grid and then store the value 1 in square 1.
 * Then, in the same allocation order as shown above, they store the sum of the values in all adjacent squares,
 * including diagonals.
 *
 * So, the first few squares' values are chosen as follows:
 *
 * Square 1 starts with the value 1.
 * Square 2 has only one adjacent filled square (with value 1), so it also stores 1.
 * Square 3 has both of the above squares as neighbors and stores the sum of their values, 2.
 * Square 4 has all three of the aforementioned squares as neighbors and stores the sum of their values, 4.
 * Square 5 only has the first and fourth squares as neighbors, so it gets the value 5.
 * Once a square is written, its value does not change.
 *
 * Therefore, the first few squares would receive the following values:
 *
 * 147  142  133  122   59
 * 304    5    4    2   57
 * 330   10    1    1   54
 * 351   11   23   25   26
 * 362  747  806--->   ...
 *
 * What is the first value written that is larger than your puzzle input?
 **/

$input = 289326;
$demo  = 23;

function get_spiral($n, $debug = false)
{
    $cur_direction            = 'R';
    $coordinates              = [0, 0];
    $top_left_coordinates     = [0, 0];
    $bottom_right_coordinates = [0, 0];
    $data                     = [
        '0,0' => 1
    ];

    echo $debug ? '1: [' . implode(',', $coordinates) . ']' . "\n" : '';
    $value = 1;
    while ($value <= $n) {
        $key     = implode(',', $coordinates);
        $x_range = range($coordinates[0] - 1, $coordinates[0] + 1);
        $y_range = range($coordinates[1] - 1, $coordinates[1] + 1);
        $value   = 0;
        foreach ($x_range as $x) {
            foreach ($y_range as $y) {
                $this_key = $x . ',' . $y;
                if (isset($data[$this_key])) {
                    $value += $data[$this_key];
                }
            }
        }
        $data[$key] = $value;

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

    return $value;
}

$test_values = [
    1,
    5,
    23,
    $input
];
$results     = array_combine(
    $test_values,
    array_map(
        'get_spiral',
        $test_values
    )
);


foreach ($results as $value => $result) {
    echo '1st Value over ' . $value . ': ' . $result . "\n";
}

// Your puzzle answer was 295229.
