<?php

declare(strict_types=1);

/**
 * --- Part Two ---
 *
 * Your calculation isn't quite right. It looks like some of the digits are actually spelled out with letters:
 * one, two, three, four, five, six, seven, eight, and nine also count as valid "digits".
 *
 * Equipped with this new information, you now need to find the real first and last digit on each line. For example:
 *
 * ```
 * two1nine
 * eightwothree
 * abcone2threexyz
 * xtwone3four
 * 4nineeightseven2
 * zoneight234
 * 7pqrstsixteen
 * ```
 *
 * In this example, the calibration values are 29, 83, 13, 24, 42, 14, and 76.
 * Adding these together produces 281.
 *
 * What is the sum of all of the calibration values?
 */

function dump(...$data): void
{
    array_walk($data, fn(mixed $item) => var_export($item));
}

function dd(...$data): void
{
    dump(...$data);
    die();
}

$numberWords = [1 => 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];

function getCalibrationValue(string $text): int
{
    global $numberWords;

    $matches = [];
    for ($i = 0, $l = strlen($text); $i < $l; $i++) {
        if (is_numeric($text[$i])) {
            $matches[] = (int)$text[$i];
            continue;
        }
        foreach($numberWords as $index => $word) {
            if (substr($text, $i, strlen($word)) === $word) {
                $matches[] = $index;
            }
        }
    }
    $pair = [current($matches), end($matches)];
    return (int)implode("", $pair);
}

function calculationCalibrationSum(string $fileName): int
{
    $lines = array_map(trim(...), file(__DIR__.'/'.$fileName));
    $numbers = array_combine($lines, array_map(getCalibrationValue(...), $lines));
//    dd($numbers);
    return array_sum($numbers);
}

//dd(getCalibrationValue('hxsevenjg6fiveeightwodps'));

echo 'Example Result: '.calculationCalibrationSum('example2.txt')."\n";
echo 'Result: '.calculationCalibrationSum('input.txt')."\n\n";

// Your puzzle answer was 54504.