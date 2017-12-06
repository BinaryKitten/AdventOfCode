<?php
/**
 * --- Part Two ---
 *
 * Now that you've helpfully marked up their design documents, it occurs to you that triangles are specified in
 * groups of three vertically. Each set of three numbers in a column specifies a triangle. Rows are unrelated.
 *
 * For example, given the following specification, numbers with the same hundreds digit would be part of the
 * same triangle:
 *
 * 101 301 501
 * 102 302 502
 * 103 303 503
 * 201 401 601
 * 202 402 602
 * 203 403 603
 *
 * In your puzzle input, and instead reading by columns, how many of the listed triangles are possible?
 */

$data_file = fopen(__DIR__ . '/data.txt', 'rb');
$valid     = 0;
foreach (triangle_from($data_file) as $triangle) {
    $valid += is_triangle_valid($triangle) ? 1 : 0;
}
echo 'There are ' . $valid . ' valid Triangles' . "\n";

fclose($data_file);

/**
 * @param $triangle
 *
 * @return bool
 */
function is_triangle_valid($triangle)
{
    sort($triangle);

    return $triangle[0] + $triangle[1] > $triangle[2];
}

/**
 * @param $line
 *
 * @return array|bool
 */
function process_line($line)
{
    if (!is_string($line)) {
        return false;
    }

    return array_map(
        'intval',
        array_values(
            array_filter(
                explode(' ', $line)
            )
        )
    );
}

/**
 * @param $data_file
 *
 * @return Generator
 */
function triangle_from($data_file)
{
    while (true) {
        $lines = array_filter([
            process_line(fgets($data_file)),
            process_line(fgets($data_file)),
            process_line(fgets($data_file)),
        ]);

        if (count($lines) !== 3) {
            break;
        }

        yield [$lines[0][0], $lines[1][0], $lines[2][0]];
        yield [$lines[0][1], $lines[1][1], $lines[2][1]];
        yield [$lines[0][2], $lines[1][2], $lines[2][2]];
    }
}
