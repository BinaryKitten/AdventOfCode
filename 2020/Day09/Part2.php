<?php

declare(strict_types=1);

/**
 * --- Part Two ---
 *
 * The final step in breaking the XMAS encryption relies on the invalid number you just found: you must find a
 *  contiguous set of at least two numbers in your list which sum to the invalid number from step 1.
 *
 * Again consider the above example:
 *
 * 35
 * 20
 * 15
 * 25
 * 47
 * 40
 * 62
 * 55
 * 65
 * 95
 * 102
 * 117
 * 150
 * 182
 * 127
 * 219
 * 299
 * 277
 * 309
 * 576
 *
 * In this list, adding up all of the numbers from 15 through 40 produces the invalid number from step 1, 127.
 *  (Of course, the contiguous set of numbers in your actual list might be much longer.)
 *
 * To find the encryption weakness, add together the smallest and largest number in this contiguous range;
 *  in this example, these are 15 and 47, producing 62.
 *
 * What is the encryption weakness in your XMAS-encrypted list of numbers?
 */
require_once __DIR__ . '/functions.php';

function findEncryptionWeakness(array $numbers, int $invalidIndex, int $invalidNumber, int $preamble): int
{
    $checksum = 0;
    $index = $invalidIndex - $preamble;
    $end = $index + 1;

    $slice = array_slice($numbers, $index, $end);

    $checksum += $numbers[$index];

    return $invalidNumber;
}

$testNumbers = getNumbers(__DIR__ . '/test.txt');
$numbers = getNumbers(__DIR__ . '/input.txt');

[$testInvalidIndex, $testInvalidNumber] = findInvalidNumber($testNumbers, preamble: 5);
[$invalidIndex, $invalidNumber] = findInvalidNumber($numbers, preamble: 25);
var_dump($testInvalidIndex, $testNumbers[$testInvalidIndex]);

$testEncryptionWeakness = findEncryptionWeakness($testNumbers, $testInvalidIndex, $testInvalidNumber, preamble: 5);
$encryptionWeakness = findEncryptionWeakness($numbers, $invalidIndex, $invalidNumber, preamble: 25);


echo 'TEST: Encryption Weakness: ' . $testEncryptionWeakness . "\n";
echo 'Encryption Weakness: ' . $encryptionWeakness . "\n\n";

