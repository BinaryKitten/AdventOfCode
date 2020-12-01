<?php

declare(strict_types=1);

/**
 * --- Part Two ---
 *
 * The Elves in accounting are thankful for your help; one of them even offers you a starfish coin they had left
 * over from a past vacation. They offer you a second one if you can find three numbers in your expense report that
 * meet the same criteria.
 *
 * Using the above example again, the three entries that sum to 2020 are 979, 366, and 675.
 * Multiplying them together produces the answer, 241861950.
 *
 * In your expense report, what is the product of the three entries that sum to 2020?
 */

$result = 0;
$input = file(__DIR__ . '/input.txt');
$input = array_map('intval', $input);
$length = count($input);

foreach ($input as $firstIndex => $number) {
    for ($secondIndex = $firstIndex + 1; $secondIndex < $length; $secondIndex++) {
        $number2 = $input[$secondIndex];
        for ($thirdIndex = $secondIndex + 1; $thirdIndex < $length; $thirdIndex++) {
            $number3 = $input[$thirdIndex];
            if (array_sum([$number, $number2, $number3]) === 2020) {
                $result = $number * $number2 * $number3;
                break 3;
            }
        }
    }
}

echo 'Result: ' . $result . "\n\n";
