<?php

$data_file = fopen(__DIR__ . '/data.txt', 'rb');

$invalid = 0;
$valid   = 0;

$triangles = [[], [], [],];

function check_triangle($side1, $side2, $side3)
{
    $result1 = ($side1 + $side2) > $side3;
    $result2 = ($side2 + $side3) > $side1;
    $result3 = ($side1 + $side3) > $side2;

    return ($result1 && $result2 && $result3);
}

$c = 0;
while ($line = fgets($data_file)) {
    $items          = array_values(array_filter(explode(' ', $line)));
    $triangles[0][] = $items[0];
    $triangles[1][] = $items[1];
    $triangles[2][] = $items[2];

    if (count($triangles[0]) === 3) {
        $valid += check_triangle(...$triangles[0]) ? 1 : 0;
        $valid += check_triangle(...$triangles[1]) ? 1 : 0;
        $valid += check_triangle(...$triangles[2]) ? 1 : 0;
        $triangles = [[], [], [],];
    }

}
echo 'There are ' . $valid . ' Triangles' . "\n";

fclose($data_file);
