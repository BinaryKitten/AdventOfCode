<?php
/**
 * --- Part Two ---
 *
 * Out of curiosity, the debugger would also like to know the size of the loop: starting from a state that has
 * already been seen, how many block redistribution cycles must be performed before that same state is seen again?
 *
 * In the example above, 2 4 1 2 is seen again after four cycles, and so the answer in that example would be 4.
 */

function reallocate_memory(array $banks)
{
    $new_state  = implode(',', $banks);
    $states     = [$new_state];
    $bank_count = count($banks);

    while (true) {
        $amount_to_redistribute = max($banks);
        $position               = array_search($amount_to_redistribute, $banks, true);
        $banks[$position]       = 0;
        $amount_to_apply        = (int)floor($amount_to_redistribute / ($bank_count - 1));
        if ($amount_to_apply === 0) {
            $amount_to_apply = 1;
        }

        while ($amount_to_redistribute > 0) {
            $position++;
            if ($position >= $bank_count) {
                $position = 0;
            }
            $banks[$position]       += $amount_to_apply;
            $old_max                = $amount_to_redistribute;
            $amount_to_redistribute -= $amount_to_apply;
            if ($old_max === $amount_to_redistribute) {
                echo $amount_to_apply . "\n";
                exit('ERROR');
            }

            if ($amount_to_apply > $amount_to_redistribute && $amount_to_redistribute > 0) {
                $amount_to_apply = $amount_to_redistribute;
            }

        }

        $new_state = implode(',', $banks);
        if (in_array($new_state, $states, true)) {
            break;
        }
        $states[] = $new_state;
    }

    return count($states) - array_search($new_state, $states, true);
}

echo reallocate_memory([0, 2, 7, 0]) . "\n";

$data  = file_get_contents('input.txt');
$banks = explode("\t", $data);

echo reallocate_memory($banks) . "\n";

// Your puzzle answer was 8038.
