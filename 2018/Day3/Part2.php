<?php
/**
 * --- Part Two ---
 * Amidst the chaos, you notice that exactly one claim doesn't overlap by even a single square inch of fabric with any
 * other claim. If you can somehow draw attention to it, maybe the Elves will be able to make Santa's suit after all!
 *
 * For example, in the claims above, only claim 3 is intact after all claims are made.
 *
 * What is the ID of the only claim that doesn't overlap?
 */

/**
 * @param array $claims
 * @return array
 */
function parse_claims(array $claims): array
{
    $regex = '/#(?P<index>\d{1,}) @ (?P<grid_x>\d+),(?P<grid_y>\d+): (?P<width>\d+)x(?P<height>\d+)/';

    return array_filter(
        array_map(function ($instruction) use ($regex) {
            if (preg_match($regex, $instruction, $data) !== false) {
                return $data;
            }
            return false;
        }, $claims)
    );
}

/**
 * @param array $parsed_claims
 * @return array
 */
function get_overlapping_claims(array $parsed_claims): array
{
    $grid = [];
    $overlapping_claims = [];

    foreach ($parsed_claims as $claim) {
        $overlap = [];

        for ($x = 0; $x < $claim['width']; $x++) {
            for ($y = 0; $y < $claim['height']; $y++) {
                $grid_location = ($claim['grid_x'] + $x) . ',' . ($claim['grid_y'] + $y);
                if (array_key_exists($grid_location, $grid)) {
                    $overlap[] = $grid[$grid_location];
                    $grid[$grid_location] = 'x';
                } else {
                    $grid[$grid_location] = $claim['index'];
                }
            }
        }
        if (!empty($overlap)) {
            $overlapping_claims[] = array_merge([$claim['index']], array_unique($overlap));
        }
    }
    $overlapping_claims = array_merge(...$overlapping_claims);


    return $overlapping_claims;
}


/**
 * @param array $parsed_claims
 * @param array $overlapping_claims
 * @return mixed
 */
function get_first_non_overlapping(array $parsed_claims, array $overlapping_claims)
{
    $data = array_diff(array_column($parsed_claims, 'index'), $overlapping_claims);
    if (!empty($data)) {
        return array_shift($data);
    }
}

$test = [
    'claims' => [
        '#1 @ 1,3: 4x4',
        '#2 @ 3,1: 4x4',
        '#3 @ 5,5: 2x2',
    ],
    'result' => 3
];

$test_parsed_claims = parse_claims($test['claims']);
$test_overlap = get_overlapping_claims($test_parsed_claims);
$test_result = get_first_non_overlapping($test_parsed_claims, $test_overlap);
echo 'Test Result: Index - ' . $test_result . ' is the 1st that does not overlap.' . "\n";


$input_claims = array_filter(file(__DIR__ . '/input.txt'));
$input_parsed_claims = parse_claims($input_claims);
$input_overlap = get_overlapping_claims($input_parsed_claims);
$input_result = get_first_non_overlapping($input_parsed_claims, $input_overlap);
echo 'Input Result: Index - ' . $input_result . ' is the 1st that does not overlap.' . "\n";
