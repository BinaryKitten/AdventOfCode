<?php
/**
 * --- Part Two ---
 *
 * Now, the jumps are even stranger: after each jump, if the offset was three or more,
 * instead decrease it by 1. Otherwise, increase it by 1 as before.
 *
 * Using this rule with the above example, the process now takes 10 steps, and the offset values after finding
 * the exit are left as 2 3 2 3 -1.
 *
 * How many steps does it now take to reach the exit?
 **/

$data         = file_get_contents('input.txt');
$instructions = array_map(
    'intval',
    array_filter(
        explode("\n", $data),
        function ($number) {
            if ($number === '') {
                return false;
            }

            return true;
        }
    )
);

//$instructions = [0, 3,  0,  1,  -3 ];

$max        = count($instructions) - 1;
$index      = 0;
$step_count = 0;


while (true) {
    $current_instruction = &$instructions[$index];
    $next_index          = $index + $current_instruction;
    if ($current_instruction >= 3) {
        $current_instruction--;
    } else {
        $current_instruction++;
    }
    $step_count++;
    if ($next_index > $max) {
        break;
    }
    $index = $next_index;
}

echo "\n The Step Count is: " . $step_count . "\n";

// Your puzzle answer was 27283023.

function debug($instructions, $step_count, $index)
{
//    echo $step_count . ': ' . "\t";
    foreach ($instructions as $pos => $int_out) {
        if ($pos === $index) {
            echo '(';
        }
        echo $int_out;
        if ($pos === $index) {
            echo ')';
        }
        echo "\t";
    }
    echo "\n";
}