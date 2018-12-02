<?php
/**
 * --- Part Two ---
 * You notice that the device repeats the same frequency change list over and over. To calibrate the device,
 * you need to find the first frequency it reaches twice.
 *
 * For example, using the same list of changes above, the device would loop as follows:
 *
 * Current frequency  0, change of +1; resulting frequency  1.
 * Current frequency  1, change of -2; resulting frequency -1.
 * Current frequency -1, change of +3; resulting frequency  2.
 * Current frequency  2, change of +1; resulting frequency  3.
 * (At this point, the device continues from the start of the list.)
 * Current frequency  3, change of +1; resulting frequency  4.
 * Current frequency  4, change of -2; resulting frequency  2, which has already been seen.
 * In this example, the first frequency reached twice is 2. Note that your device might need to repeat its list of
 * frequency changes many times before a duplicate frequency is found, and that duplicates might be found while in the
 * middle of processing the list.
 *
 * Here are other examples:
 *
 * +1, -1 first reaches 0 twice.
 * +3, +3, +4, -2, -4 first reaches 10 twice.
 * -6, +3, +8, +5, -6 first reaches 5 twice.
 * +7, +7, -2, -7, -4 first reaches 14 twice.
 * What is the first frequency your device reaches twice?
 */

$tests = [
    [
        'data' => [+1, -1],
        'result' => 0
    ],
    [
        'data' => [+3, +3, +4, -2, -4],
        'result' => 10,
    ],
    [
        'data' => [-6, +3, +8, +5, -6],
        'result' => 5,
    ],
    [
        'data' => [+7, +7, -2, -7, -4],
        'result' => 14,
    ]
];

foreach ($tests as $test) {
    $generated_result = generate_result($test['data']);
    printf(
        'Test: %d === %d: %s' . "\n",
        $generated_result,
        $test['result'],
        $generated_result === $test['result'] ? ' Pass' : 'Fail'
    );
}

function generate_result(array $data)
{
    $frequencies = [0];
    $frequency = 0;
    while (true) {
        foreach ($data as $step => $adjustment) {
            printf(
                '%d: %d + %d = %d' . "\n",
                $step,
                $frequency,
                $adjustment,
                $frequency + $adjustment
            );
            $frequency += $adjustment;
            if (in_array($frequency, $frequencies, true)) {
                break 2;
            }
            $frequencies[] = $frequency;
        }
    }
    return $frequency;
}

$data = array_map('\intval', file(__DIR__ . '/input.txt'));
$result = generate_result($data);
echo 'Result: ' . $result . "\n\n";

// Your puzzle answer was 137041.