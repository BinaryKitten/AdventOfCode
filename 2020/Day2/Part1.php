<?php

declare(strict_types=1);

/**
 * --- Day 2: Password Philosophy ---
 *
 * Your flight departs in a few days from the coastal airport; the easiest way down to the coast from here is
 * via toboggan.
 *
 * The shopkeeper at the North Pole Toboggan Rental Shop is having a bad day. "Something's wrong with our computers;
 * we can't log in!" You ask if you can take a look.
 *
 * Their password database seems to be a little corrupted: some of the passwords wouldn't have been allowed by the
 * Official Toboggan Corporate Policy that was in effect when they were chosen.
 *
 * To try to debug the problem, they have created a list (your puzzle input) of passwords (according to the corrupted
 * database) and the corporate policy when that password was set.
 *
 * For example, suppose you have the following list:
 *
 * 1-3 a: abcde
 * 1-3 b: cdefg
 * 2-9 c: ccccccccc
 *
 * Each line gives the password policy and then the password. The password policy indicates the lowest and highest
 * number of times a given letter must appear for the password to be valid. For example, 1-3 a means that the password
 * must contain a at least 1 time and at most 3 times.
 *
 * In the above example, 2 passwords are valid. The middle password, cdefg, is not; it contains no instances of b,
 * but needs at least 1. The first and third passwords are valid: they contain one a or nine c, both within the
 * limits of their respective policies.
 *
 * How many passwords are valid according to their policies?
 */

$input = file(__DIR__ . '/input.txt');
$output_array = [];
$valid = [];
foreach ($input as $input_line) {
    preg_match('/(?P<min>\d{1,})-(?P<max>\d{1,}) (?P<letter>[a-z]): (?P<password>.+)/', $input_line, $output_array);
    $chars = array_filter(count_chars($output_array['password']));
    $chars = array_combine(
        array_map('chr', array_keys($chars)),
        $chars
    );
    if (!array_key_exists($output_array['letter'], $chars)) {
        continue;
    }
    $letterCount = $chars[$output_array['letter']];
    if ($letterCount < $output_array['min'] || $letterCount > $output_array['max']) {
        continue;
    }

    $valid[] = $output_array['password'];
}

echo 'Result: ' . count($valid) . "\n\n";

// Your puzzle answer was 439.
