<?php
/**
 * --- Day 6: Signals and Noise ---
 *
 * Something is jamming your communications with Santa. Fortunately, your signal is only partially jammed,
 * and protocol in situations like this is to switch to a simple repetition code to get the message through.
 *
 * In this model, the same message is sent repeatedly. You've recorded the repeating message signal
 * (your puzzle input), but the data seems quite corrupted - almost too badly to recover. Almost.
 *
 * All you need to do is figure out which character is most frequent for each position.
 * For example, suppose you had recorded the following messages:
 *
 * eedadn
 * drvtee
 * eandsr
 * raavrd
 * atevrs
 * tsrnev
 * sdttsa
 * rasrtv
 * nssdts
 * ntnada
 * svetve
 * tesnvt
 * vntsnd
 * vrdear
 * dvrsen
 * enarar
 * The most common character in the first column is e; in the second, a; in the third, s, and so on.
 * Combining these characters returns the error-corrected message, easter.
 *
 * Given the recording in your puzzle input, what is the error-corrected version of the message being sent?
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
    arsort($charList);
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