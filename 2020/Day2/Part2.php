<?php

declare(strict_types=1);

/**
 * --- Part Two ---
 *
 * While it appears you validated the passwords correctly, they don't seem to be what the
 *      Official Toboggan Corporate Authentication System is expecting.
 *
 * The shopkeeper suddenly realizes that he just accidentally explained the password policy rules from his old job
 *      at the sled rental place down the street!
 * The Official Toboggan Corporate Policy actually works a little differently.
 *
 * Each policy actually describes two positions in the password, where 1 means the first character, 2 means the
 *  second character, and so on. (Be careful; Toboggan Corporate Policies have no concept of "index zero"!)
 * Exactly one of these positions must contain the given letter. Other occurrences of the letter are irrelevant
 * for the purposes of policy enforcement.
 *
 * Given the same example list from above:
 *
 * 1-3 a: abcde is valid: position 1 contains a and position 3 does not.
 * 1-3 b: cdefg is invalid: neither position 1 nor position 3 contains b.
 * 2-9 c: ccccccccc is invalid: both position 2 and position 9 contain c.
 *
 * How many passwords are valid according to the new interpretation of the policies?
 */

$input = file(__DIR__ . '/input.txt');
$output_array = [];
$valid = [];
foreach ($input as $input_line) {
    preg_match(
        '/(?P<pos1>\d{1,})-(?P<pos2>\d{1,}) (?P<letter>[a-z]): (?P<password>.+)/',
        $input_line,
        $output_array
    );

    if ($output_array['pos2'] > strlen($output_array['password'])) {
        continue;
    }
    $letterPos1 = $output_array['password'][$output_array['pos1'] - 1];
    $letterPos2 = $output_array['password'][$output_array['pos2'] - 1];

    if ($letterPos1 !== $output_array['letter'] && $letterPos2 !== $output_array['letter']) {
        continue;
    }
    if ($letterPos1 === $letterPos2 && $letterPos1 === $output_array['letter']) {
        continue;
    }

    $valid[] = $output_array['password'];
}

echo 'Result: ' . count($valid) . "\n\n";

// Your puzzle answer was 584.
