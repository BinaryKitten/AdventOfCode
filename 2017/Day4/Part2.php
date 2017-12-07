<?php
/**
 * --- Part Two ---
 *
 * For added security, yet another system policy has been put in place.
 * Now, a valid passphrase must contain no two words that are anagrams of each other -
 * that is, a passphrase is invalid if any word's letters can be rearranged to form any other word in the passphrase.
 *
 * For example:
 *
 * abcde fghij is a valid passphrase.
 * abcde xyz ecdab is not valid - the letters from the third word can be rearranged to form the first word.
 * a ab abc abd abf abj is a valid passphrase, because all letters need to be used when forming another word.
 * iiii oiii ooii oooi oooo is valid.
 * oiii ioii iioi iiio is not valid - any of these words can be rearranged to form any other word.
 * Under this new system policy, how many passphrases are valid?
 *
 * Although it hasn't changed, you can still get your puzzle input.
 */

$data = file_get_contents('input.txt');
$data = explode("\n", $data);
$data = array_filter($data);

$valid_passphrases = 0;
foreach ($data as $row) {
    $words = explode(' ', $row);
    sort($words);
    $valid_passphrases += (int)(count($words) === count(array_unique($words)));
}

echo 'How many passphrases are valid?' . "\n";
echo 'Answer: ' . $valid_passphrases . "\n";

//Your puzzle answer was 477.
