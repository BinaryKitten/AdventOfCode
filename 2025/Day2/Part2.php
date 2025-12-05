<?php

declare(strict_types=1);

/**
 * --- Part Two ---
 *
 * The clerk quickly discovers that there are still invalid IDs in the ranges in your list.
 * Maybe the young Elf was doing other silly patterns as well?
 *
 * Now, an ID is invalid if it is made only of some sequence of digits repeated at least twice.
 * So, 12341234 (1234 two times), 123123123 (123 three times), 1212121212 (12 five times),
 *  and 1111111 (1 seven times) are all invalid IDs.
 *
 * From the same example as before:
 *
 * 11-22 still has two invalid IDs, 11 and 22.
 * 95-115 now has two invalid IDs, 99 and 111.
 * 998-1012 now has two invalid IDs, 999 and 1010.
 * 1188511880-1188511890 still has one invalid ID, 1188511885.
 * 222220-222224 still has one invalid ID, 222222.
 * 1698522-1698528 still contains no invalid IDs.
 * 446443-446449 still has one invalid ID, 446446.
 * 38593856-38593862 still has one invalid ID, 38593859.
 * 565653-565659 now has one invalid ID, 565656.
 * 824824821-824824827 now has one invalid ID, 824824824.
 * 2121212118-2121212124 now has one invalid ID, 2121212121.
 *
 * Adding up all the invalid IDs in this example produces 4174379265.
 *
 * What do you get if you add up all of the invalid IDs using these new rules?
 */

function getIDs(string $fileName): array
{
    $f = fopen($fileName, 'r');
    $data = fgetcsv($f);
    fclose($f);

    return array_map(fn(string $id) => explode('-', trim($id)), $data);
}

function isIdInvalid(int|string $id): bool
{
    $id = (string)$id;
    $length = mb_strlen($id);
    $splitPoint =  (int) floor($length / 2);

    $segment = mb_substr($id, 0, $splitPoint);
    $segment2 = mb_substr($id, $splitPoint);
    if ($segment === $segment2) {
        return true;
    }

    $matches = [];
    for ($patternLength = 1; $patternLength <= $splitPoint; $patternLength++) {
        $checkPattern = mb_substr($id, 0, $patternLength);
        $matchPattern = "/^(" . $checkPattern . ")\\1{2,}$/";
        $match = preg_match($matchPattern, $id, $matches);
        if ($match === 1) {
            return true;
        }
    }

    return false;
}

function processFile(string $fileName): int
{
    $ids = getIDs($fileName);

    $total = 0;
    foreach ($ids as [$firstId, $lastId]) {
        $idRange = range($firstId, $lastId);
        $invalidRange = array_filter($idRange, isIdInvalid(...));
        if (empty($invalidRange)) {
            continue;
        }
        $total += array_sum($invalidRange);
    }

    return $total;
}

echo "Example Result: ".processFile('example1.txt')."\n";
echo "Input Result: ".processFile('input.txt')."\n";

// Your puzzle answer was 22617871034.