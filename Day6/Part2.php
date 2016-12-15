<?php
/**
 * --- Part Two ---
 *
 * Of course, that would be the message - if you hadn't agreed to use a modified repetition code instead.
 *
 * In this modified code, the sender instead transmits what looks like random data, but for each character,
 * the character they actually want to send is slightly less likely than the others. Even after signal-jamming
 * noise, you can look at the letter distributions in each column and choose the least common letter to
 * reconstruct the original message.
 *
 * In the above example, the least common character in the first column is a; in the second, d, and so on.
 * Repeating this process for the remaining characters produces the original message, advent.
 *
 * Given the recording in your puzzle input and this new decoding methodology, what is the original message
 * that Santa is trying to send?
 */

$message = array_fill(0, 8, []);
//var_dump($message);
foreach (line_in(__DIR__ . '/data.txt') as $line) {
    $chars = str_split($line);
    foreach ($chars as $idx => $char) {
        $message[$idx][] = $char;
    }
}
foreach ($message as $idx => $charList) {
    $charList = array_count_values($charList);
    asort($charList);
    $chars         = array_keys($charList);
    $message[$idx] = array_shift($chars);
}
echo implode('', $message) . "\n";

function line_in($file)
{
    $f = fopen($file, 'rb');
    while ($line = fgets($f)) {
        yield trim($line);
    }
    fclose($f);
}