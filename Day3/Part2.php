<?php

function check_triangle($side1, $side2, $side3)
{
    $result1 = ($side1 + $side2) > $side3;
    $result2 = ($side2 + $side3) > $side1;
    $result3 = ($side1 + $side3) > $side2;

    return ($result1 && $result2 && $result3);
}

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

function get_triangle($data_file)
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

$data_file = fopen(__DIR__ . '/data.txt', 'rb');
$valid     = 0;
foreach (get_triangle($data_file) as $triangle) {
    $valid += check_triangle(...$triangle) ? 1 : 0;
}
echo 'There are ' . $valid . ' Triangles' . "\n";

fclose($data_file);
