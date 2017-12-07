<?php
/**
 * --- Day 4: High-Entropy Passphrases ---
 *
 * A new system policy has been put in place that requires all accounts to use a passphrase instead of simply
 * a password.
 *
 * A passphrase consists of a series of words (lowercase letters) separated by spaces.
 *
 * To ensure security, a valid passphrase must contain no duplicate words.
 *
 * For example:
 *
 * aa bb cc dd ee is valid.
 * aa bb cc dd aa is not valid - the word aa appears more than once.
 * aa bb cc dd aaa is valid - aa and aaa count as different words.
 * The system's full passphrase list is available as your puzzle input.
 *
 * How many passphrases are valid?
 */

$data = file_get_contents('input.txt');
$data = explode("\n", $data);
$data = array_filter($data);

$valid_passphrases = 0;
foreach ($data as $row) {
    $words = explode(' ', $row);
    $valid_passphrases += (int)(count($words) === count(array_unique($words)));
}

echo 'How many passphrases are valid?' . "\n";
echo 'Answer: ' . $valid_passphrases . "\n";

//Your puzzle answer was 477.
