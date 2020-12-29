<?php

declare(strict_types=1);

function getNumbers(string $file): array
{
    return array_map('intval', file($file));
}

/**
 * @param int[] $numbers
 * @param int $curIndex
 * @param int $preamble
 * @return int[]
 */
function getSums(array $numbers, int $curIndex, int $preamble): array
{
    $sums = [];
    for ($stepIndex = $curIndex - $preamble, $end = $curIndex - 1; $stepIndex <= $end; $stepIndex++) {
        for ($otherStep = $stepIndex; $otherStep <= $end; $otherStep++) {
            $sums[] = $numbers[$stepIndex] + $numbers[$otherStep];
        }
    }
    return $sums;
}

/**
 * @param int[] $numbers
 * @param int $preamble
 * @return array{0:int, 1:int}
 */
function findInvalidNumber(array $numbers, int $preamble): array
{
    $currentNumber = -1;
    for ($index = $preamble, $last = array_key_last($numbers); $index <= $last; $index++) {
        $currentNumber = $numbers[$index];
        if (!in_array($currentNumber, getSums($numbers, $index, $preamble), true)) {
            break;
        }
    }
    return [$index, $currentNumber];
}