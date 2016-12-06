<?php

function check_triangle($side1, $side2, $side3)
{
    $result1 = ($side1 + $side2) > $side3;
    $result2 = ($side2 + $side3) > $side1;
    $result3 = ($side1 + $side3) > $side2;

    return ($result1 && $result2 && $result3);
}

function get_triangle($data_file)
{
    while ($line = fgets($data_file)) {
        yield array_map(
            'intval',
            array_values(
                array_filter(
                    explode(' ', $line)
                )
            )
        );
    }
}

$data_file = fopen(__DIR__ . '/data.txt', 'rb');
$valid   = 0;
foreach (get_triangle($data_file) as $triangle) {
    $valid += check_triangle(...$triangle) ? 1 : 0;
}
echo 'There are ' . $valid . ' Triangles' . "\n";

fclose($data_file);
