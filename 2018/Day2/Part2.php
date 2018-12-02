<?php
/**
 * --- Part Two ---
 * Confident that your list of box IDs is complete, you're ready to find the boxes full of prototype fabric.
 *
 * The boxes will have IDs which differ by exactly one character at the same position in both strings. For example,
 * given the following box IDs:
 *
 * abcde
 * fghij
 * klmno
 * pqrst
 * fguij
 * axcye
 * wvxyz
 * The IDs abcde and axcye are close, but they differ by two characters (the second and fourth).
 * However, the IDs fghij and fguij differ by exactly one character, the third (h and u).
 * Those must be the correct boxes.
 *
 * What letters are common between the two correct box IDs? (In the example above, this is found by removing the
 * differing character from either ID, producing fgij.)
 */

$test_data = [
    'abcde',
    'fghij',
    'klmno',
    'pqrst',
    'fguij',
    'axcye',
    'wvxyz',
];

$data = array_map('str_split', $test_data);

function get_diff(string $boxId1, string $boxId2)
{
    $diff = [];
    for ($i = 0, $l = strlen($boxId1); $i < $l; $i++) {
        if ($boxId1[$i] !== $boxId2[$i]) {
            $diff[$i] = [$boxId1[$i], $boxId2[$i]];
        }
    }
    return $diff;
}


function generate_result($boxIds): string
{
    foreach ($boxIds as $index => $boxId1) {
        for ($i = $index + 1, $l = \count($boxIds); $i < $l; $i++) {
            $boxId2 = $boxIds[$i];
            $diff = get_diff($boxId1, $boxId2);
            if (\count($diff) === 1) {
                break 2;
            }
        }
    }

    return substr_replace($boxId1, '', array_keys($diff)[0], 1);
}


printf('Result of Test is: %s', generate_result($test_data));
echo "\n";


$data = array_filter(file(__DIR__ . '/input.txt'));
printf('Result: %s', generate_result($data));
echo "\n";


// Your puzzle answer was rmyxgdlihczskunpfijqcebtv.