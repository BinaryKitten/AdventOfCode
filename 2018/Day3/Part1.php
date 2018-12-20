<?php
/**
 * --- Day 3: No Matter How You Slice It ---
 * The Elves managed to locate the chimney-squeeze prototype fabric for Santa's suit (thanks to someone who helpfully
 * wrote its box IDs on the wall of the warehouse in the middle of the night). Unfortunately, anomalies are still
 * affecting them - nobody can even agree on how to cut the fabric.
 *
 * The whole piece of fabric they're working on is a very large square - at least 1000 inches on each side.
 *
 * Each Elf has made a claim about which area of fabric would be ideal for Santa's suit. All claims have an ID and
 * consist of a single rectangle with edges parallel to the edges of the fabric. Each claim's rectangle is defined
 * as follows:
 *
 * The number of inches between the left edge of the fabric and the left edge of the rectangle.
 * The number of inches between the top edge of the fabric and the top edge of the rectangle.
 * The width of the rectangle in inches.
 * The height of the rectangle in inches.
 * A claim like #123 @ 3,2: 5x4 means that claim ID 123 specifies a rectangle 3 inches from the left edge, 2 inches
 * from the top edge, 5 inches wide, and 4 inches tall. Visually, it claims the square inches of fabric represented
 * by # (and ignores the square inches of fabric represented by .) in the diagram below:
 *
 * ...........
 * ...........
 * ...#####...
 * ...#####...
 * ...#####...
 * ...#####...
 * ...........
 * ...........
 * ...........
 * The problem is that many of the claims overlap, causing two or more claims to cover part of the same areas.
 * For example, consider the following claims:
 *
 * #1 @ 1,3: 4x4
 * #2 @ 3,1: 4x4
 * #3 @ 5,5: 2x2
 * Visually, these claim the following areas:
 *
 * ........
 * ...2222.
 * ...2222.
 * .11XX22.
 * .11XX22.
 * .111133.
 * .111133.
 * ........
 * The four square inches marked with X are claimed by both 1 and 2. (Claim 3, while adjacent to the others,
 * does not overlap either of them.)
 *
 * If the Elves all proceed with their own plans, none of them will have enough fabric.
 * How many square inches of fabric are within two or more claims?
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
function create_grid(array $parsed_claims): array
{
    $grid = [];

    foreach ($parsed_claims as $claim) {
        for ($x = 0; $x < $claim['width']; $x++) {
            for ($y = 0; $y < $claim['height']; $y++) {
                $grid_location = ($claim['grid_x'] + $x) . ',' . ($claim['grid_y'] + $y);
                if (array_key_exists($grid_location, $grid)) {
                    $grid[$grid_location] = 'x';
                } else {
                    $grid[$grid_location] = $claim['index'];
                }
            }
        }
    }
    return $grid;
}

/**
 * @param $grid
 * @return int
 */
function get_overlapping_inches($grid): int
{
    $overlap = array_filter($grid, function ($value) {
        return $value === 'x';
    });
    return \count($overlap);
}

$test = [
    'claims' => [
        '#1 @ 1,3: 4x4',
        '#2 @ 3,1: 4x4',
        '#3 @ 5,5: 2x2',
    ],
    'result' => 4
];

$test_parsed_claims = parse_claims($test['claims']);
$test_grid = create_grid($test_parsed_claims);
$test_result = get_overlapping_inches($test_grid);
echo 'Test Result = ' . $test_result . ' Inches Overlapping.' . "\n";

$input_claims = array_filter(file(__DIR__ . '/input.txt'));
$input_parsed_claims = parse_claims($input_claims);
$input_grid = create_grid($input_parsed_claims);
$input_result = get_overlapping_inches($input_grid);
echo 'Input Result = ' . $input_result . ' Inches Overlapping.' . "\n";


// Your puzzle answer was 115242.