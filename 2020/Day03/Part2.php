<?php

declare(strict_types=1);

/**
 * --- Part Two ---
 *
 * Time to check the rest of the slopes - you need to minimize the probability of a sudden arboreal stop, after all.
 *
 * Determine the number of trees you would encounter if, for each of the following slopes, you start at the top-left
 * corner and traverse the map all the way to the bottom:
 *
 * Right 1, down 1.
 * Right 3, down 1. (This is the slope you already checked.)
 * Right 5, down 1.
 * Right 7, down 1.
 * Right 1, down 2.
 *
 * In the above example, these slopes would find 2, 7, 3, 4, and 2 tree(s) respectively; multiplied together,
 * these produce the answer 336.
 */

$map = parseMap(__DIR__ . '/input.txt');
$testData = [
    [$map, 1, 1],
    [$map, 3, 1],
    [$map, 5, 1],
    [$map, 7, 1],
    [$map, 1, 2],
];

$results = array_map(
    static function ($testItem) {
        $traMap = traverse(...$testItem);
        $cv = array_count_values(array_merge(...$traMap));
        return $cv['X'];
    },
    $testData
);
$endValue = array_reduce($results, fn(?int $carry, int $value) => $carry === null ? $value : $carry * $value);

echo 'Result: ' . $endValue . "\n";

// Your puzzle answer was 200.

function traverse(array $map, $x = 3, $y = 1): array
{
    $lastRow = count($map);
    $coords = ['x' => 0, 'y' => 0];
    do {
        $rowWidth = count($map[$coords['y']]);
        $coords['x'] += $x;
        if ($coords['x'] >= $rowWidth) {
            $coords['x'] -= $rowWidth;
        }
        $coords['y'] += $y;
        $space = &$map[$coords['y']][$coords['x']];
        $space = $space === '#' ? 'X' : 'O';
    } while ($coords['y'] < $lastRow);

    return $map;
}

function parseMap($mapFile): array
{
    return array_map(fn(string $line) => str_split(trim($line)), file($mapFile));
}